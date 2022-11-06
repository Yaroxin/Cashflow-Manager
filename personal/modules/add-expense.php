<?php

if (isset($_POST["addExpenseDate"]) && isset($_POST["addExpenseCat"]) && isset($_POST["addExpenseAccount"]) && isset($_POST["addExpenseSumm"]) && isset($_POST["addExpenseCurrencyId"]) ) {    
    require "../../db.php";
    session_start();
    require "../userDB.php";
    require "../../functions.php";

    $expense = R::dispense('expense');
    $expense['date'] = $_POST["addExpenseDate"];
    $expense['expensecategory_id'] = $_POST["addExpenseCat"];
    if($_POST["addExpenseSubCat"]){
        $expense['expensesubcategory_id'] = $_POST["addExpenseSubCat"];
    }    
    $expense['account_id'] = $_POST["addExpenseAccount"];
    $expense['summ'] = $_POST["addExpenseSumm"];
    $expense['currency_id'] = $_POST["addExpenseCurrencyId"];
    $expense['note'] = $_POST["addExpenseNote"];
    R::store($expense);

    $category = R::load('expensecategory', $_POST["addExpenseCat"]);
    $category['status'] = 1;
    R::store($category);

    $subCategories = R::find('expensesubcategory', 'expensecategory_id = ?', [$_POST["addExpenseCat"]]);
    if($subCategories){
        foreach($subCategories as $subCategory){
            $subCategory['status'] = 1;
            R::store($subCategory);
        }        
    }

    if(getBalance($_POST["addExpenseAccount"]) == 0){
        $account =R::load('account', $_POST["addExpenseAccount"]);
        $account['status'] = 1;
        R::store($account);
    }else{
        $account =R::load('account', $_POST["addExpenseAccount"]);
        $account['status'] = 3;
        R::store($account);
    } 

    $result = 'Расход добавлен!';
    echo json_encode($result);

}else{
    echo json_encode('Error Add');
}