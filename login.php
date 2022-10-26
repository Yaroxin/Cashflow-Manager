<?php

$data = $_POST;
if (isset($data['login'])) {
    $errors = array();
    $user = R::findOne('users', 'email = ?', array($data['email']));

    if(!$user) {
        $user = R::findOne('users', 'login = ?', array($data['email']));
    }

    if($user) {
        if(password_verify($data['password'], $user['password'])) {            
            session_start();
            $_SESSION['logged_user'] = $user;

            if($data['remember']){
                $key = generateSalt();
                setcookie('email', $user['email'], strtotime("+30 days"));
                setcookie('login', $user['login'], strtotime("+30 days"));
                setcookie('key', $key, strtotime("+30 days"));

                $user->cookie = $key;
                R::store($user);
            }

            if($user['status'] != 'demo'){
                header('location: /personal/home.php');
            }else{
                header('location: /personal/home.php?month=1&year=2021');
            }
           
        }else {
            $errors[] = 'Incorecct Password';
        }
    }else {
        $errors[] = 'User does not exist.';
    }
}

?>
