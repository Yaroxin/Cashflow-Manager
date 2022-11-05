<?php

function generateSalt(){
    $salt = '';
    $saltLength = 8; //длина соли
    for($i=0; $i<$saltLength; $i++) {
        $salt .= chr(mt_rand(33,126)); //символ из ASCII-table
    }
    return $salt;
}

function getBalance($account_id){
    $account = R::load('account', $account_id);
    $incomes = R::find('income', 'account_id = ?', [$account_id]);
    $expenses = R::find('expense', 'account_id = ?', [$account_id]);

    $incomesSumm = 0;
    $expensesSumm = 0;

    foreach($incomes as $income){
        $incomesSumm += $income['summ'];
    }

    foreach($expenses as $expense){
        $expensesSumm += $expense['summ'];
    }

    return ($account['startbalance'] + $incomesSumm) - $expensesSumm;
}

function getFullBalance(){
    $accounts = R::findAll('account');

    $fullSumm = 0;

    foreach($accounts as $acc){
        $fullSumm += getBalance($acc['id']);
    }

    return $fullSumm;
}

function getCategoryList($cat){
    $categories = R::findAll($cat);
}