<?php

if ( isset($_POST['accountId'], $_POST['accountStatus']) ) {    
    require "../db.php";
    session_start();
    require "userDB.php";

    if($_POST['accountStatus'] == 0){
        $account = R::load('account', $_POST['accountId']);
        R::trash($account);
        echo json_encode('Deleted');
    }

    if($_POST['accountStatus'] == 1){
        $account = R::load('account', $_POST['accountId']);
        $account['status'] = 2;
        R::store($account);
        echo json_encode('Archived');
    }

    if($_POST['accountStatus'] == 2){
        $account = R::load('account', $_POST['accountId']);
        $account['status'] = 1;
        R::store($account);
        echo json_encode('Activated');
    }

    

}else{
    echo json_encode($_POST['accountId'] . '-' . $_POST['accountStatus']);
}