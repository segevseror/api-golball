<?php

namespace Controllers\Main;

class HomeController extends \Controllers\Controller{
    public function __construct($parma){
        echo 'wait..... ';
    }

    public function Index(){
        echo 'successfully completed';
        return 'successfully completed';
    }
}