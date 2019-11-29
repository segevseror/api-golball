<?php

namespace Controllers\Main;

class HomeController extends \Controllers\Controller{
    public function __construct($parma){
    }

    public function Index(){
        global $db;
 
        $result = pg_query($db, "SELECT username FROM users");
        
     foreach(pg_fetch_all($result) as $user){
         echo $user['username'];
     }
        echo 'successfully completed';
    }
}