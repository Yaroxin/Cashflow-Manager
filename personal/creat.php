<?php
session_start();
session_destroy();
header('location: /personal/home.php');

// require "../db.php";
// session_start();
// require "userDB.php";

// $expenseCategory = R::dispense('expensecategory');
// $expenseCategory['name'] = 'Налоги';

// $expenseSubCategory = R::dispense('expensesubcategory');
// $expenseSubCategory['name'] = 'Транспортный';
// $expenseSubCategory['expensecategory_id'] = 1;

// $incomeCategory = R::dispense('incomecategory');
// $incomeCategory['name'] = 'Трудовой доход';

// $incomeSubCategory = R::dispense('incomesubcategory');
// $incomeSubCategory['name'] = 'Зарплата';
// $incomeSubCategory['incomecategory_id'] = 1;

// R::store($incomeCategory);
// R::store($incomeSubCategory);
// R::store($expenseCategory);
// R::store($expenseSubCategory);