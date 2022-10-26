<?php

if (isset($_POST["accName"]) && isset($_POST["accStartBalance"]) && isset($_POST["accCurrency"]) ) {    
    require "../db.php";
    session_start();
    require "userDB.php";

    $account = R::find('account', 'name = :name AND currency = :currency', [':name' => $_POST["accName"], ':currency' => $_POST["accCurrency"]]);

    if($account){
        $result = 'Счет уже есть!';
    }else{

        if($_POST["inBalance"] == 'on'){
            $inBalance = 1;
        }else{
            $inBalance = 0;
        }

        if($_POST["isCredit"] == 'on'){
            $isCredit = 1;
        }else{
            $isCredit = 0;
        }

        $account = R::dispense('account');
        $account['name'] = $_POST["accName"];
        $account['startbalance'] = $_POST["accStartBalance"];
        $account['currency_id'] = $_POST["accCurrency"];
        $account['inbalance'] = $inBalance;
        $account['iscredit'] = $isCredit;
        R::store($account);

        $result = 'Счет добавлен!';
    }

    echo json_encode($result);

}else{
    echo json_encode('Error Add');
}