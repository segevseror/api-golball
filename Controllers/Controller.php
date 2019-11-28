<?php

namespace Controllers;

abstract class Controller {
    protected $set;
    protected static $inst = null;
    protected $get;
    protected $post;
    protected $params;
    protected function __construct($params = []){
        global $set;
        $this->set = $set;
        $this->params = $params;
        $set->lang="HEB";
        $set->webLang = "HEB";
    }

    protected function AdminHeader() {
        adminHeader();
    }

    protected function showAdminTree() {
        showAdminTree($this->set->get['act']);
    }

    public function theme($page,$data = []) {
        $html = view('header',$data);
        $html .= view($page,$data);
        $html .= view('footer',$data);
        echo $html;
    }

    public function render($page , $data = [],$theme = 'default') {
        global $set, $query;
        require_once('orderClass.php');
        $headerData['menuHeaderSlider'] = getMainCategoryData();
        $headerData['user'] = getUserUSA();
        $headerData['query'] = $query;
        $this->cart = new \orderClass;
        $cart = $this->cart->getCart();
        $headerData['countCartItems']= count($cart['items']);
 
        
        $data = array_merge(['user'=>$headerData['user']] ,$data);
      
     

        $html = '';
        $html .= $this->view($theme.'/shared/header',$headerData);
        $html .= $this->view($theme.'/'.$page, $data );
        $html .= $this->view($theme.'/shared/footer',$data);
        echo $html;
    }
    public function gettempl($page , $data = [],$theme = 'default') {
        global $set;
        
        $html = $this->view($theme.'/'.$page,$data);
        return $html;
    }

    public function view(string $___, array $data) : string
    {
        GLOBAL $set;
        extract($data);
        //
        ob_start();
        require 'templ/'.$___.'.php';
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
       

    public static function Load($controller,$params = []) {
        $t = explode("/",$controller);
        array_unshift($t,'Controllers');
        $controllerPath = implode("\\",$t);
        if ($controllerPath::$inst == null) {
            $controllerPath::$inst = new $controllerPath($params);
        }
        return $controllerPath::$inst;
    }

    public static function RunRouter($routeInfo) :bool {

     
        $splitUp = static::determineControllerAndMethod($routeInfo[1]);

        if (!static::CheckController($splitUp)) {
            return false;
        }

        $controller = new $splitUp->fullClass(null);
        if (!method_exists($controller,$splitUp->method)) {
            return false;
        }
        
        $params = static::manageParams($routeInfo[2],$controller,$splitUp);
        if ($params === null) {
            return false;
        }
        call_user_func_array([$controller,$splitUp->method],$params);
        return true;
    }

    private static function manageParams($params,&$controller,$info) :?array{
        $params = array_values($params);

        foreach($params as $key=>&$param) {
            $tmp = new \ReflectionParameter([$controller,$info->method],$key);
            $className = $tmp->getClass()->name; 
            if ($className !== null) {
                
                $param = (int)$param;
                if(in_array('Modules\Model',class_implements($className))) {
                    $paramObject = $className::_CreateObjectByID_($param);
                    if ($paramObject === null) {
                        return null;
                    }
                    $param = $paramObject;
                } else {
                    return null;
                }
            }
        }
        return $params;
    }

    private static function CheckController($info) :bool{
        if (!file_exists($info->physicalPath)) {
            return false;
        }
        require_once $info->physicalPath;
        if (!class_exists($info->fullClass)) {
            return false;
        }
        return true;
    }

    private static function determineControllerAndMethod($info) {
        $class = $info;
        $parts = explode("@", $class);
        $fullPath ="Controllers/".$parts[0];
        $classFullPath = str_replace("/","\\",$fullPath);
        $fullPath.='.php';

        $result = new \stdClass;
        $result->fullClass = $classFullPath;
        $result->physicalPath = $fullPath;
        if ($parts[1]) {
            $result->method = $parts[1];
        } else {
            $result->method = 'Index';
        }

        require 'dbase.php';

        return $result;
    }
}