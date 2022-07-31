<?php
    require '..\db.php';
    if(isset($_SESSION['logged_user'])):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="../css/reset.css">
    <title>Document</title>
</head>
<body>
    <div class="headBlock">
        <div class="topMenu">
            <div class="moreButton">More</div>
            <div class="userName">Roman Yarokhin</div>
            <div class="logoutButton">Exit</div>
        </div>
        <div class="balanceItem">133 952,00 &#8381;</div>
        <div class="balanceItem">952,10 &#36;</div>
        <div class="balanceItem">152,75 &#128;</div>
    </div>
    <div class="itemsBlock">
        <div class="homeItem" onclick="document.location.href = 'accounts.php';">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Accounts</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Incomes</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Expenses</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Debts</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Credits</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Budget</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Categories</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Contractors</span>
        </div>
        <div class="homeItem">
            <img src="img/coin.png" alt="itemTitle">
            <span class="itemTitle">Currencies</span>
        </div>        
    </div>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>