<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";
    $categories = R::findAll($_GET['cat']);
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
            <div class="topBarLeft"><a href="/">Назад</a></div>
            <div class="topBarCenter">Роман Ярохин</div>
            <div class="topBarRight"><a href="logout.php">Выход</a></div>
        </div>
        <div class="categoryContent">
            <div class="tabs">
                <?php if($_GET['cat'] == 'incomecategory'): ?>
                <?php $table = 'incomesubcategory'; ?>
                <div id="categoryIncomeTab" class="tab tabActive" onclick="changeCatTab(this);">Категории доходов</div>
                <div id="categoryExpenseTab" class="tab" onclick="changeCatTab(this);">Категории расходов</div>
                <?php elseif($_GET['cat'] == 'expensecategory'): ?>
                <?php $table = 'expensesubcategory'; ?>
                <div id="categoryIncomeTab" class="tab" onclick="changeCatTab(this);">Категории доходов</div>
                <div id="categoryExpenseTab" class="tab tabActive" onclick="changeCatTab(this);">Категории расходов</div>
                <?php else: ?>
                <div id="categoryIncomeTab" class="tab" onclick="changeCatTab(this);">Категории доходов</div>
                <div id="categoryExpenseTab" class="tab" onclick="changeCatTab(this);">Категории расходов</div>
                <?php endif; ?>
            </div>
            <div class="categoriesList">
                <?php if($categories): ?>
                    <?php foreach($categories as $category): ?>
                        <?php $subCategoryCount = R::count( $table, $_GET['cat'] . '_id  = ?', [$category['id']] ); ?>
                        <div class="category">
                            <div class="categoryCentralBlock">
                                <div class="categoryName"><?php echo $category['name']; ?></div>
                                <div class="subCategories">Подкатегории: <?php echo $subCategoryCount; ?></div>
                            </div>
                            <div class="categoryRightBlock"></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>     
                <div class="button">
                    <a href="addCategory.php?cat=<?php echo $_GET['cat']; ?>">Добавить категорию</a>
                </div>           
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>