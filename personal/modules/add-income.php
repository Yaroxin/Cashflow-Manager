<?php

if (isset($_POST["addIncomeDate"]) && isset($_POST["addIncomeCat"]) && isset($_POST["addIncomeAccount"]) && isset($_POST["addIncomeSumm"]) && isset($_POST["addIncomeCurrencyId"]) ) {    
    require "../../db.php";
    session_start();
    require "../userDB.php";

    $income = R::dispense('income');
    $income['date'] = $_POST["addIncomeDate"];
    $income['incomecategory_id'] = $_POST["addIncomeCat"];
    $income['incomesubcategory_id'] = $_POST["addIncomeSubCat"];
    $income['account_id'] = $_POST["addIncomeAccount"];
    $income['summ'] = $_POST["addIncomeSumm"];
    $income['currency_id'] = $_POST["addIncomeCurrencyId"];
    $income['note'] = $_POST["addIncomeNote"];
    R::store($income);

    $account =R::load('account', $_POST["addIncomeAccount"]);
    $account['status'] = 1;
    R::store($account);

    $result = 'Доход добавлен!';
    echo json_encode($result);

}else{
    echo json_encode('Error Add');
}