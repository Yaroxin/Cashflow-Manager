<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";
    // $categories = R::findAll($_GET['cat']);
    $activeCategories = R::find($_GET['cat'], 'status != ?', [2] );
    $archiveCategories = R::find($_GET['cat'], 'status = ?', [2] );

    if ($SHOW_ARCHIVE_CATEGORIES){
        $categories = array_merge($activeCategories, $archiveCategories);
    }else{
        $categories = $activeCategories;
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
            <div class="topBarLeft"><a href="/">Назад</a></div>
            <div class="topBarCenter">Роман Ярохин</div>
            <div class="topBarRight"><a href="logout.php">Выход</a></div>
        </div>
        <div class="categoryContent">
            <div class="tabs">
                <?php if($_GET['cat'] == 'incomecategory'): ?>
                <?php 
                    $subCategoryTable = 'incomesubcategory';
                    $table = 'income';
                ?>
                <div id="categoryIncomeTab" class="tab tabActive" onclick="changeCatTab(this);">Категории доходов</div>
                <div id="categoryExpenseTab" class="tab" onclick="changeCatTab(this);">Категории расходов</div>
                <?php elseif($_GET['cat'] == 'expensecategory'): ?>
                <?php 
                    $subCategoryTable = 'expensesubcategory';
                    $table = 'expense';
                ?>
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
                        <?php $subCategoryCount = R::count( $subCategoryTable, $_GET['cat'] . '_id  = ?', [$category['id']] ); ?>
                        <?php if($category['status'] != 2): ?>
                        <div class="category">
                            <div class="categoryCentralBlock" onclick="window.location='category.php?id=<?php echo $category['id']; ?>&cat=<?php echo $_GET['cat']; ?>&filter=Month'">
                                <div class="categoryName"><?php echo $category['name']; ?></div>
                                <div class="subCategories">Подкатегории: <?php echo $subCategoryCount; ?></div>
                            </div>
                            <div class="categoryRightBlock">
                                <?php 
                                    $allowDelete = R::find( $table, $_GET['cat'] . '_id  = ?', [$category['id']] );
                                    if(!$allowDelete):
                                ?>
                                <?php ?>
                                <div class="delCategory" onclick="deleteCategory( '<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>', '<?php echo $table; ?>' );">
                                    <img src="img/can.png" alt="delCategory">
                                </div>
                                <?php else: ?>
                                <div class="archCategory" onclick="archCategory('<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>');">
                                    <img src="img/folder.png" alt="archCategory">
                                </div>
                                <?php endif; ?>
                                <div class="editCategory">
                                    <img src="img/edit.png" alt="editCategory">
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="category archiveCategory">
                            <div class="categoryCentralBlock">
                                <div class="categoryName"><?php echo $category['name']; ?></div>
                                <div class="subCategories">Подкатегории: <?php echo $subCategoryCount; ?></div>
                            </div>
                            <div class="categoryRightBlock">                                
                                <div class="activateCategory" onclick="actCategory('<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>', '<?php echo $table; ?>');">
                                    <img src="img/file.png" alt="activateCategory">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
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