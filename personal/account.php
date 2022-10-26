<?php
    require "../db.php"; 
    require "../config.php";
    require "../functions.php";  
    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php 
    require "userDB.php"; 
    $account = R::Load('account', $_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"; ?>
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
            <div class="accBalance">&#8381; 19 500.00</div>
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

        </div>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>