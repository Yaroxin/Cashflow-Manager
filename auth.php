<?php

if (empty($_SESSION['logged_user']) or $_SESSION['logged_user'] == false) {

    if ( !empty($_COOKIE['login']) and !empty($_COOKIE['email']) and !empty($_COOKIE['key']) ) {
        $email = $_COOKIE['email']; 
        $login = $_COOKIE['login']; 
        $key = $_COOKIE['key'];

        $user = R::findOne('users', 'email = ?', [$email]);

        if(!$user) {
            $user = R::findOne('users', 'login = ?', [$login]);
        }
        
        if ($user) {
            session_start();
            $_SESSION['logged_user'] = $user;
        }
    }
}