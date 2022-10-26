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
                <div class="mainPage mainPageActive">
                    <div class="mainPageImg">
                        <img src="img/coin.png" alt="page">
                    </div>
                    <div class="mainPageName">Доходы</div>
                </div>
                <div class="mainPage">
                    <div class="mainPageImg">
                        <img src="img/coin.png" alt="page">
                    </div>
                    <div class="mainPageName">Расходы</div>
                </div>                
            </div>
        </div>
        <div class="list">


            <?php if($account['status'] == 0): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Удалить счет</div>
            <?php endif; ?>
            <?php if($account['status'] == 1): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >В архив</div>
            <?php endif; ?>
            <?php if($account['status'] == 2): ?>        
            <div id="delAccount" class="delAccount" data-id="<?php echo $account['id']; ?>" data-status="<?php echo $account['status']; ?>" >Активировать счет</div>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>