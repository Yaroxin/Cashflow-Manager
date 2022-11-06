<?php

if (isset($_POST["addIncomeDate"]) && isset($_POST["addIncomeCat"]) && isset($_POST["addIncomeAccount"]) && isset($_POST["addIncomeSumm"]) && isset($_POST["addIncomeCurrencyId"]) ) {    
    require "../../db.php";
    session_start();
    require "../userDB.php";
    require "../../functions.php";

    $income = R::dispense('income');
    $income['date'] = $_POST["addIncomeDate"];
    $income['incomecategory_id'] = $_POST["addIncomeCat"];
    if($_POST["addIncomeSubCat"]){
        $income['incomesubcategory_id'] = $_POST["addIncomeSubCat"];
    }    
    $income['account_id'] = $_POST["addIncomeAccount"];
    $income['summ'] = $_POST["addIncomeSumm"];
    $income['currency_id'] = $_POST["addIncomeCurrencyId"];
    $income['note'] = $_POST["addIncomeNote"];
    R::store($income);

    $category = R::load('incomecategory', $_POST["addIncomeCat"]);
    $category['status'] = 1;
    R::store($category);

    $subCategories = R::find('incomesubcategory', 'incomecategory_id = ?', [$_POST["addIncomeCat"]]);
    if($subCategories){
        foreach($subCategories as $subCategory){
            $subCategory['status'] = 1;
            R::store($subCategory);
        }        
    }

    if(getBalance($_POST["addIncomeAccount"]) == 0){
        $account =R::load('account', $_POST["addIncomeAccount"]);
        $account['status'] = 1;
        R::store($account);
    }else{
        $account =R::load('account', $_POST["addIncomeAccount"]);
        $account['status'] = 3;
        R::store($account);
    }    

    $result = 'Доход добавлен!';
    echo json_encode($result);

}else{
    echo json_encode('Error Add');
}