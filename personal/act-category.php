<?php

if ( isset($_POST["categoryId"]) && isset($_POST["catTable"]) && isset($_POST["subCatTable"]) && isset($_POST["table"]) ) {
    require "../db.php";
    session_start();
    require "userDB.php";
    
    $transactions = R::find($_POST["table"], $_POST["catTable"] . '_id  = ?', [$_POST["categoryId"]] );

    if($transactions){
        $status = 1;
    }else{
        $status = 0; 
    }
    
    $category = R::load($_POST["catTable"], $_POST["categoryId"]);
    $category['status'] = $status;
    R::store($category); 

    $subCategories = R::find( $_POST["subCatTable"], $_POST["catTable"] . '_id  = ?', [$_POST["categoryId"]] );
    if($subCategories){
        foreach($subCategories as $subCategory){
            $subCategory['status'] = $status;
            R::store($subCategory);
        }
    }

    $response = [
        'message' => 'Категория Активна!',
    ];       
    

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

}else{
    
    $response = [
        'message' => 'Error archive Category',
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}