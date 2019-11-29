<?php

namespace Controllers\Main;

class userConroller extends \Controllers\Controller{
    public function __construct($parma){
        
    }

    public function RegisterUser(){
        global $db;
        $userName = $_POST['username'];
        $pass = $_POST['password'];
        $phone = $_POST['phone'];
        $errors = [];
        if(!$userName){
            $errors['usename'] = 'you most give the username';
        }
        if(!$pass){
            $errors['password'] = 'you most give the password';
        }
        if($errors){
            echo json_encode(['act' => false , 'message' => $errors]);
            return false;
        }else{

            if(!$phone){
                $phone = '00';
            };
            //checkif username is exists;
            $checkUser = pg_query($db ,"SELECT id FROM users WHERE username = '$userName'");
            if(pg_affected_rows($checkUser)){
                echo json_encode(['act' => false , 'message' => 'the username is exists']);
                return false;
            }else{

                $result = pg_query($db, "INSERT INTO users(username , pass , phone ) VALUES('$userName', '$pass' , '$phone')");
                if($result){
                    $user = pg_fetch_array(pg_query($db ,"SELECT id,username FROM users WHERE username = '$userName'"));
                    echo json_encode(['act' => true , 'data' => [
                        'id' => $user['id'],
                        'username' => $user['username']
                    ]]);
                    return true;
                }else{
                    echo json_encode(['act' => false]);
                    return false;
                }
            }
            echo 'error 0000';
            return false;

        }


    }

    public function getUsers(){
        global $db;

        $result = pg_query('SELECT id,username FROM users');
        $list = pg_fetch_all($result);
        echo json_encode($list);
        return 'true';

    }
    public function Index(){
        var_dump($_POST);
        $arr =['segev' ,'seror'];
        echo json_encode($arr);
    }
}