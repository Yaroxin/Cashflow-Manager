<?php

if ( isset($_POST["categoryId"]) && isset($_POST["catTable"]) && isset($_POST["subCatTable"]) ) {
    require "../db.php";
    session_start();
    require "userDB.php";    
    
    $category = R::load($_POST["catTable"], $_POST["categoryId"]);
    $category['status'] = 2;
    R::store($category); 

    $subCategories = R::find( $_POST["subCatTable"], $_POST["catTable"] . '_id  = ?', [$_POST["categoryId"]] );
    if($subCategories){
        foreach($subCategories as $subCategory){
            $subCategory['status'] = 2;
            R::store($subCategory);
        }
    }

    $response = [
        'message' => 'Категория в Архиве!',
    ];       
    

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

}else{
    
    $response = [
        'message' => 'Error archive Category',
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}