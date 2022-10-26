<?php
    require "../db.php"; 
    require "../config.php";
    require "../functions.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    $accounts = R::findAll('account');
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"; ?>
<body>  
    <div class="wrap">
        <?php include_once "topBar.php"; ?>
        <div class="mainBlock">
            <div class="mainLogo">
                <img src="img/coin.png" alt="Logo">
            </div>
            <div class="mainName">My Wallet</div>
            <?php include_once "mainPages.php"; ?>
        </div>
        <div class="list">


            <?php if($accounts): ?>
                <?php foreach($accounts as $acc): ?>


            <div id="accLine-<?php echo $acc['id']; ?>" class="accLine" data-id="<?php echo $acc['id']; ?>">
                <div class="accLineImg">
                    <img src="img/coin.png" alt="account">
                </div>
                <div class="accLineCenterBlock">
                    <div class="accLineName"><?php echo $acc['name']; ?></div>
                    <div class="accLineBalance">
                        <?php
                            $currency = R::Load('currency', $acc['currency_id']);
                            echo $currency['htmlcode'];
                        ?>
                        19 500.00</div>
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
            <?php endif; ?>


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