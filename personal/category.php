<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";  
    $category = R::Load($_GET['cat'], $_GET['id']);
    $filters = ['All', 'Year', 'Month', 'Week'];

    if($_GET['cat'] == 'incomecategory'){
        $table = 'income';
    }
    if($_GET['cat'] == 'expensecategory'){
        $table = 'expense';
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

        <div class="accBlock">
            <div class="accLogo">
                <img src="img/coin.png" alt="Logo">
            </div>
            <div class="accName"><?php echo $category['name']; ?></div>            
        </div>

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



        
            <?php if($category['status'] == 0): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Удалить категорию</div>
            <?php endif; ?>
            <?php if($category['status'] == 1): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >В архив</div>
            <?php endif; ?>
            <?php if($category['status'] == 2): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Активировать</div>
            <?php endif; ?>





        </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>