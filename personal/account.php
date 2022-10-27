<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";  
    $account = R::Load('account', $_GET['id']);
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
            <div class="accName"><?php echo $account['name']; ?></div>
            <?php if($account['status'] == 2): ?>        
            <div class="accStatus">Архивный</div>
            <?php endif; ?>
            <div class="accBalance"><?php echo $account->currency->htmlcode; ?> <?php echo number_format(getBalance($account['id']), 2, '.', ' '); ?></div>
            <div class="accOptionsBlock">
                <?php if($account['inbalance'] == 1): ?>
                <div class="inBalance">В балансе</div>
                <?php else: ?>
                <div class="inBalance">Вне баланса</div>
                <?php endif; ?>
                <?php if($account['iscredit'] == 1): ?>
                <div class="isCredit">Кредитный</div>
                <?php else: ?>
                <div class="isCredit">Дебитовый</div>
                <?php endif; ?>
            </div>
            <div class="accPages">
                <?php if($_GET['page'] == 'income'): ?>
                <div id="accIncomesPage" class="accPage accPageActive" data-id="<?php echo $_GET['id']; ?>">
                <?php else: ?>
                <div id="accIncomesPage" class="accPage" data-id="<?php echo $_GET['id']; ?>">
                <?php endif; ?>
                    <div class="accPageImg">
                        <img src="img/coin.png" alt="page">
                    </div>
                    <div class="accPageName">Доходы</div>
                </div>
                <?php if($_GET['page'] == 'expense'): ?>
                <div id="accExpensesPage" class="accPage accPageActive" data-id="<?php echo $_GET['id']; ?>">
                <?php else: ?>
                <div id="accExpensesPage" class="accPage" data-id="<?php echo $_GET['id']; ?>">
                <?php endif; ?>
                    <div class="accPageImg">
                        <img src="img/coin.png" alt="page">
                    </div>
                    <div class="accPageName">Расходы</div>
                </div>                
            </div>
        </div>
        <div class="list">
        <?php if($_GET['page'] == 'income'): ?>
            <?php $incomes = R::find('income', 'account_id = ?', [$_GET['id']]); ?>
            <div id="incomesList" class="incomesList">
                <?php if($incomes): ?>
                    <?php foreach($incomes as $income): ?>
                        <div class="incomeLine">
                            <div class="incomeLineDate"><?php echo $income['date']; ?></div> 
                            <div class="incomeLineBottom">
                                <div class="incomeLineLeft">
                                    <div class="incomeLineCat"><?php echo $income->incomecategory->name; ?></div>
                                    <div class="incomeLineSubCat"><?php echo $income->incomesubcategory->name; ?></div>                    
                                </div>
                                <div class="incomeLineRight">
                                    <div class="incomeLineSumm"><?php echo $income->currency->htmlcode; ?> <?php echo $income['summ']; ?></div>
                                    <div class="incomeLineAccount"><?php echo $income->account->name; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="incomeLine">Нет доходов</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if($_GET['page'] == 'expense'): ?>
            <?php $expenses = R::find('expense', 'account_id = ?', [$_GET['id']]); ?>
            <div id="expensesList" class="expensesList">
                <?php if($expenses): ?>
                    <?php foreach($expenses as $expense): ?>
                        <div class="incomeLine">
                            <div class="incomeLineDate"><?php echo $expense['date']; ?></div> 
                            <div class="incomeLineBottom">
                                <div class="incomeLineLeft">
                                    <div class="incomeLineCat"><?php echo $expense->expensecategory->name; ?></div>
                                    <div class="incomeLineSubCat"><?php echo $expense->expensesubcategory->name; ?></div>                    
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
        <?php endif; ?>
            <?php if($account['status'] == 0): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Удалить счет</div>
            <?php endif; ?>
            <?php if($account['status'] == 1): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >В архив</div>
            <?php endif; ?>
            <?php if($account['status'] == 2): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Активировать счет</div>
            <?php endif; ?>
            <?php if($account['status'] == 3): ?>        
            <div class="toArchive">Для архивации нужен нулевой баланс</div>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>