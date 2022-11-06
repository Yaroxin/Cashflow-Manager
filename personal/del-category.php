<?php

if ( isset($_POST["categoryId"]) && isset($_POST["catTable"]) && isset($_POST["subCatTable"]) && isset($_POST["table"]) ) {
    require "../db.php";
    session_start();
    require "userDB.php";

    $allowDelete = R::find( $_POST["table"], $_POST["catTable"] . '_id  = ?', [$_POST["categoryId"]] );
    
    if(!$allowDelete){
        $category = R::load($_POST["catTable"], $_POST["categoryId"]);
        $subCategories = R::find( $_POST["subCatTable"], $_POST["catTable"] . '_id  = ?', [$_POST["categoryId"]] );
        R::trash($category);
        R::trashAll($subCategories);

        $response = [
            'message' => 'Категория удалена!',
        ];
        
    }else{
        $response = [
            'message' => 'Нельзя удалить!',
        ];
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

}else{
    
    $response = [
        'message' => 'Error delete Category',
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}