<?php

namespace Controllers\Main;

class userConroller extends \Controllers\Controller{
    public function __construct($parma){
        
    }

    public function RegisterUser(){
  
        global $conn;
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
            $checkUser = $conn->prepare("SELECT id FROM users WHERE username = :username");
            $checkUser->execute([':username' => $userName]);
            if(!empty($checkUser->fetch())){
                echo json_encode(['act' => false , 'message' => 'the username is exists']);
                return false;
            }else{
                $adduser = $conn->prepare("INSERT INTO users(username , pass , phone ) VALUES(:username , :pass , :phone)");
                $adduser->execute([':username' => $userName , ':pass' => $pass , ':phone' => $phone]);
                if($adduser->rowCount() > 0){
                    $getuser = $conn->prepare("SELECT id,username FROM users WHERE username = :username ");
                    $getuser->execute([':username' => $userName]);
                    $getuser = $getuser->fetch();
                    echo json_encode(['act' => true , 'data' => [
                        'id' => $getuser['id'],
                        'username' => $getuser['username']
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
        global $conn;

        $users = $conn->prepare('SELECT id,username FROM users');
        $users->execute();
        $userArr = array();
        while($user = $users->fetchAll()){
            $userArr += $user;
        };
        echo json_encode($userArr);
        return 'true';

    }
    public function Index(){
    }
}