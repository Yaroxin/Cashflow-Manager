<?php
    require "../db.php"; 
    require "../config.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    require "../functions.php";

    $activeAccounts = R::find('account', 'status != ?', [2]);
    $archiveAccounts = R::find('account', 'status = ?', [2]);

    if ($SHOW_ARCHIVE){
        $accounts = array_merge($activeAccounts, $archiveAccounts);
    }else{
        $accounts = $activeAccounts;
    }    

    if($_SESSION['logged_user']['status'] == 'free'){
        $modules = R::find('module', 'status = ?', [$_SESSION['logged_user']['status']]);
    }
    if($_SESSION['logged_user']['status'] == 'premium'){
        $modules = R::findAll('module');
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
        <?php include_once "topBar.php"; ?>
        <div class="mainBlock">
            <div class="mainLogo">
                <img src="img/coin.png" alt="Logo">
            </div>
            <div class="mainName"><?php echo number_format(getFullBalance(), 2, '.', ' '); ?></div>
            <?php include_once "mainPages.php"; ?>
        </div>
        <div class="list">
                <?php foreach($accounts as $acc): ?>
                    <div id="accLine-<?php echo $acc['id']; ?>" class="accLine accStatus-<?php echo $acc['status']; ?>" data-id="<?php echo $acc['id']; ?>">
                        <div class="accLineImg">
                            <img src="img/coin.png" alt="account">
                        </div>
                        <div class="accLineCenterBlock">
                            <div class="accLineName"><?php echo $acc['name']; ?></div>
                            <?php if($acc['status'] == 2): ?>
                            <div class="accLineIsArchive accLineBalance">Архивный</div>
                            <?php endif; ?>
                            <div class="accLineBalance">
                                <?php echo $acc->currency->htmlcode; ?>
                                <?php echo number_format(getBalance($acc['id']), 2, '.', ' '); ?>
                            </div>
                        </div>
                        <div class="accLineRightBlock">
                            <?php if($acc['iscredit'] == 0): ?>
                                <div class="accLineOptionsTop">Дебитовый</div>
                            <?php else: ?>
                                <div class="accLineOptionsTop">Кредитный</div>
                            <?php endif; ?>

                            <?php if($acc['inbalance'] == 0): ?>
                            <div class="accLineOptions">Вне баланса</div>
                            <?php else: ?>
                            <div class="accLineOptions">В балансе</div> 
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>            

            <div class="addAccount">
                <a href="addAccount.php">Добавить счет</a>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>

</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>