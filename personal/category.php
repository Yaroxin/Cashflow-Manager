<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php"; 
    
    if ($_GET['cat'] == 'incomecategory' || $_GET['cat'] == 'incomesubcategory'){
        $category = R::Load('incomecategory', $_GET['id']);
        $catTitle = 'Категория доходов';
        $tabTitle = 'Доходы по категории';
        $backURL = 'categories.php?cat=incomecategory';
    }    
    if ($_GET['cat'] == 'expensecategory' || $_GET['cat'] == 'expensesubcategory'){
        $category = R::Load('expensecategory', $_GET['id']);
        $catTitle = 'Категория расходов';
        $tabTitle = 'Расходы по категории';
        $backURL = 'categories.php?cat=expensecategory';
    }

    $filters = ['All', 'Year', 'Month', 'Week'];

    if($_GET['cat'] == 'incomecategory'){
        $table = 'income';
        $subCategoryTable = 'incomesubcategory';
        $catTitle = 'Категория доходов';        
    }
    if($_GET['cat'] == 'expensecategory'){
        $table = 'expense';
        $subCategoryTable = 'expensesubcategory';
        $catTitle = 'Категория расходов';        
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
            <div class="topBarLeft"><a href="<?php echo $backURL; ?>">Назад</a></div>
            <div class="topBarCenter">Роман Ярохин</div>
            <div class="topBarRight"><a href="logout.php">Выход</a></div>
        </div>        
        <?php if($category['status'] != 2): ?>
            <div class="accBlock">
        <?php else: ?>
            <div class="accBlock archive">
        <?php endif; ?>
            <div class="accLogo">
                <img src="img/coin.png" alt="Logo">
            </div>
            <div class="accName"><?php echo $category['name']; ?></div>
            <div class="catStatus"><?php echo $catTitle; ?></div>
            <?php if($category['status'] == 2): ?>
                <div class="catStatus">В Архиве</div>
            <?php endif; ?>
        </div>

        <div class="tabs">
            <?php if ($_GET['cat'] == 'incomecategory' || $_GET['cat'] == 'expensecategory'): ?>
                <div id="incomesInCategory" class="tab tabActive" onclick="changeTabCatPage(this);"><?php echo $tabTitle; ?></div>
                <div id="subCategoryTab" class="tab" onclick="changeTabCatPage(this);">Подкатегории</div>
            <?php elseif($_GET['cat'] == 'incomesubcategory' || $_GET['cat'] == 'expensesubcategory' ): ?>
                <div id="incomesInCategory" class="tab" onclick="changeTabCatPage(this);"><?php echo $tabTitle; ?></div>
                <div id="subCategoryTab" class="tab tabActive" onclick="changeTabCatPage(this);">Подкатегории</div>
            <?php endif; ?>
        </div>


        <?php if ($_GET['cat'] == 'incomecategory' || $_GET['cat'] == 'expensecategory'): ?>
        <div class="incomeFilter">
            <?php foreach($filters as $filter): ?>
                <?php if($_GET['filter'] == $filter): ?>
                    <div id="<?php echo $filter; ?>" class="incomeFilterItem incomeFilterItemActive" onclick="changeFilter(this);"><?php echo $filter; ?></div>
                <?php else: ?>
                    <div id="<?php echo $filter; ?>" class="incomeFilterItem" onclick="changeFilter(this);"><?php echo $filter; ?></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="list">
            <?php
                if($_GET['filter'] == 'All'){
                    $transactions = R::find($table, $_GET['cat'] . '_id = ?', [$_GET['id']] );
                }
                if($_GET['filter'] == 'Year'){
                    $transactions = R::getAll( "SELECT * FROM " . $table . " WHERE YEAR(date) =" . date("Y") . " AND " . $_GET['cat'] . "_id =" . $_GET['id'] );
                    $transactions = R::convertToBeans($_GET['cat'], $transactions);
                }
                if($_GET['filter'] == 'Month'){
                    $transactions = R::getAll( "SELECT * FROM " . $table . " WHERE MONTH(date) = " . date("m") . " AND YEAR(date) =" . date("Y") . " AND " . $_GET['cat'] . "_id =" . $_GET['id'] );
                    $transactions = R::convertToBeans($_GET['cat'], $transactions);
                }
                if($_GET['filter'] == 'Week'){
                    $transactions = R::getAll( "SELECT * FROM " . $table . " WHERE `date` > NOW() - INTERVAL 7 DAY" . " AND " . $_GET['cat'] . "_id =" . $_GET['id']  );
                    $transactions = R::convertToBeans($_GET['cat'], $transactions);
                } 
            ?>
            <div id="incomesList" class="incomesList">
                <?php if($transactions): ?>
                    <?php foreach($transactions as $transaction): ?>
                        <div class="incomeLine">
                            <div class="incomeLineDate"><?php echo $transaction['date']; ?></div> 
                            <div class="incomeLineBottom">
                                <div class="incomeLineLeft">
                                    <?php if($_GET['cat'] == 'incomecategory'): ?>
                                    <div class="incomeLineCat"><?php echo $transaction->incomecategory->name; ?></div>
                                    <div class="incomeLineSubCat"><?php echo $transaction->incomesubcategory->name; ?></div> 
                                    <?php endif; ?>                   
                                    <?php if($_GET['cat'] == 'expensecategory'): ?>
                                    <div class="incomeLineCat"><?php echo $transaction->expensecategory->name; ?></div>
                                    <div class="incomeLineSubCat"><?php echo $transaction->expensesubcategory->name; ?></div> 
                                    <?php endif; ?>                   
                                </div>
                                <div class="incomeLineRight">
                                    <div class="incomeLineSumm"><?php echo $transaction->currency->htmlcode; ?> <?php echo $transaction['summ']; ?></div>
                                    <div class="incomeLineAccount"><?php echo $transaction->account->name; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="incomeLine">Нет доходов</div>
                <?php endif; ?>
            </div>
            <div class="buttonsBlock">
                <div class="button buttonCategory"><a href="editCategory.php?id=<?php echo $_GET['id']; ?>&cat=<?php echo $_GET['cat']; ?>">Изменить</a></div>

                <?php if($category['status'] == 0): ?>        
                <div class="button buttonCategory" onclick="deleteCategory( '<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>', '<?php echo $table; ?>' );" >Удалить</div>
                <?php endif; ?>
                <?php if($category['status'] == 1): ?>        
                <div class="button buttonCategory" onclick="archCategory('<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>');">В архив</div>
                <?php endif; ?>
                <?php if($category['status'] == 2): ?>
                <div class="button buttonCategory" onclick="actCategory('<?php echo $category['id']; ?>', '<?php echo $_GET['cat']; ?>', '<?php echo $subCategoryTable; ?>', '<?php echo $table; ?>');">Активировать</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($_GET['cat'] == 'incomesubcategory' || $_GET['cat'] == 'expensesubcategory'): ?>
            <?php
                if($_GET['cat'] == 'incomesubcategory'){
                    $subCategories = R::find($_GET['cat'], 'incomecategory_id = ?', [$_GET['id']] );
                    $editURL = 'editCategory.php?id=' . $_GET['id'] . '&cat=incomecategory';
                }
                if($_GET['cat'] == 'expensesubcategory'){
                    $subCategories = R::find($_GET['cat'], 'expensecategory_id = ?', [$_GET['id']] );
                    $editURL = 'editCategory.php?id=' . $_GET['id'] . '&cat=expensecategory';
                }                
            ?>
            <div class="categoriesList">
                <?php if($subCategories): ?>
                    <?php foreach($subCategories as $subCategory): ?>
                        <div class="category">
                            <div class="categoryCentralBlock">
                                <div class="categoryName"><?php echo $subCategory['name']; ?></div>
                            </div>
                            <div class="categoryRightBlock">                                
                                <div class="delCategory">
                                    <img src="img/can.png" alt="delCategory">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="incomeLine">Нет Подкатегорий</div>
                <?php endif; ?>
                <div class="buttonsBlock">
                    <div class="button buttonCategory"><a href="<?php echo $editURL; ?>">Изменить</a></div>
                    <div class="button buttonCategory">
                        <a href="#">Добавить</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>