<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";

    if ($_GET['cat'] == 'incomecategory'){
        $catTitle = 'Добавить категорию доходов';
    }

    if ($_GET['cat'] == 'expensecategory'){
        $catTitle = 'Добавить категорию расходов';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="../css/reset.css">
    <title><?php echo $APP_NAME; ?></title>
</head>
<body>  
    <div class="wrap">
        <div class="topBar">
            <div class="topBarLeft"><a href="/personal/category.php?cat=<?php echo $_GET['cat']; ?>">Назад</a></div>
            <div class="topBarCenter">Роман Ярохин</div>
            <div class="topBarRight"><a href="logout.php">Выход</a></div>
        </div>
        <div class="addCategoryTitle"><?php echo $catTitle; ?></div>
        <form id="addCategoryForm" class="addCategoryForm" action="" method="POST">
            <label class="addCategoryLabel" for="categoryName">Название категории:</label>
            <input class="addCategoryInput" id="categoryName" name="addCategoryName" type="text" maxlength="64" required>
            <input type="hidden" name="addCategoryTable" value="<?php echo $_GET['cat']; ?>">
            <div id="addSubCategoryBlock" class="addSubCategoryBlock"></div>
            <div id="addSubCategoryButton" class="checkboxBlock">
                <div class="addSubCategoryButton">
                    <img src="img/add.png" alt="">
                </div>
                <div class="addSubCategoryTitle">Добавить подкатегорию</div>
            </div>
            <input id="subCategoriesCount" type="hidden" name="subCategoriesCount" value="0">
            <input id="addCategoryButton" name="addCategoryButton" class="button disabledButton" type="submit" value="Добавить" disabled>
        </form>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>