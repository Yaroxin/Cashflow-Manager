<?php

require "../db.php";
session_start();
require "userDB.php";

if (isset($_POST['catId']) && !empty($_POST['catId'])) {
    if($_POST['table'] == 'addIncomeCat'){
        $subCategory = R::find('incomesubcategory', 'incomecategory_id = ?', [$_POST['catId']]);
    }
    if($_POST['table'] == 'addExpenseCat'){
        $subCategory = R::find('expensesubcategory', 'expensecategory_id = ?', [$_POST['catId']]);
    }    

    if($subCategory){
        echo json_encode(array_column($subCategory, 'id', 'name'));
    }
}

if (isset($_POST['accountId']) && !empty($_POST['accountId'])) {
    $account = R::load('account', $_POST['accountId']);

    if($account){
        $currency = [
            'id' => $account->currency->id,
            'lettcode' => $account->currency->lettcode,
        ];
        echo json_encode($currency);
    }
}