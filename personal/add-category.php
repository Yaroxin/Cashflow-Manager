<?php

if ( isset($_POST["addCategoryName"]) && isset($_POST["addCategoryTable"]) && isset($_POST["subCategoriesCount"]) ) {
    $response = [];
    require "../db.php";
    session_start();
    require "userDB.php";

    $subCategoriesCount = $_POST["subCategoriesCount"];

    if($subCategoriesCount == 0){
        $category = R::dispense($_POST["addCategoryTable"]);
        $category['name'] = $_POST["addCategoryName"];
        R::store($category);
        $response = [
            'url' => 'category.php?cat=' . $_POST["addCategoryTable"],
            'message' => 'Категория добавлена!',
        ];
    }

    if($subCategoriesCount > 0){

        $category = R::dispense($_POST["addCategoryTable"]);
        $category['name'] = $_POST["addCategoryName"]; 
        R::store($category);       

        if($_POST["addCategoryTable"] == 'incomecategory'){
            $tableName = 'incomesubcategory';
            $tableId = 'incomecategory_id';
        }
        if($_POST["addCategoryTable"] == 'expensecategory'){
            $tableName = 'expensesubcategory';
            $tableId = 'expensecategory_id';
        }
        
        $subCategories = [];
        for ($i = 1; $i <= $subCategoriesCount; $i++) {
            if($_POST["addSubCategory" . $i] != ''){
                $subCategory = R::dispense($tableName);
                $subCategory['name'] = $_POST["addSubCategory" . $i];
                $subCategory[$tableId] = $category['id'];
                
                $subCategories [] = $subCategory;
            }
        }
    
        if ( !empty($subCategories) ){
            R::storeAll($subCategories);
            $response = [
                'url' => 'category.php?cat=' . $_POST["addCategoryTable"],
                'message' => 'Категория и подкатегории добавлены!',
            ];
        }
        
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

}else{
    
    $response = [
        'url' => '',
        'message' => 'Error Add',
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}