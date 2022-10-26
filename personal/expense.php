<?php
    require "../db.php"; 
    require "../config.php";
    require "../functions.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php";
    $expenses = R::findAll('expense');
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"; ?>
<body>  
    <div class="wrap">
        <?php include_once "topBar.php"; ?>
        <div class="accBlock">
            <div class="accLogo">
                <img src="img/coin.png" alt="Logo">
            </div>
            <div class="accName">Расходы</div>
            <div class="accBalance">&#8381; 1 190 500.00</div>            
        </div>
        <div class="incomeFilter">
            <div class="incomeFilterItem incomeFilterItemActive">All</div>
            <div class="incomeFilterItem">Year</div>
            <div class="incomeFilterItem">Month</div>
            <div class="incomeFilterItem">Week</div>
        </div>
        <div class="list">
            <?php if($expenses): ?>
                <?php foreach($expenses as $expense): ?>
                    <div class="incomeLine">
                        <div class="incomeLineDate"><?php echo $expense['date']; ?></div> 
                        <div class="incomeLineBottom">
                            <div class="incomeLineLeft">
                                <div class="incomeLineCat"><?php echo $expense->incomecategory->name; ?></div>
                                <div class="incomeLineSubCat"><?php echo $expense->incomesubcategory->name; ?></div>                    
                            </div>
                            <div class="incomeLineRight">
                                <div class="incomeLineSumm"><?php echo $expense->currency->htmlcode; ?> <?php echo $expense['summ']; ?></div>
                                <div class="incomeLineAccount"><?php echo $expense->account->name; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="incomeLine">Нет расходов</div>
            <?php endif; ?>
        </div>
        <div id="addIncome" class="addIncome"> <a href="addExpense.php">Добавить</a> </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>