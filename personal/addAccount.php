<?php
    require "../db.php"; 
    require "../config.php";
    require "userDB.php";    

    session_start();    
    if(isset($_SESSION['logged_user'])):
?>

<!DOCTYPE html>
<html lang="en">
<?php include "head.php"; ?>
<body>  
    <div class="wrap">
        <?php include_once "topBar.php"; ?>
        <form id="addAccountForm" class="addAccountForm" action="" method="POST">
            <input class="addAccountInput" type="text" name="accName" required placeholder="Название счета" maxlength="64" value="www">
            <input class="addAccountInput" type="text" name="accStartBalance" required placeholder="Начальный баланс" inputmode="decimal" maxlength="16" value="10000">
            <select class="accCurrency" name="accCurrency" id="accCurrency" require>
                <option value="" disabled selected style='display:none;'>Валюта счета</option>
                <option value="3">RUB</option>
                <option value="1">USD</option>
                <option value="2">EUR</option>
            </select>
            <div class="addAccountCheckboxBlock">
                <input id="inBalance" type="checkbox" name="inBalance" checked>
                <label for="inBalance">Учитывать в балансе</label>
                <input id="isCredit" type="checkbox" name="isCredit">
                <label for="isCredit">Кредитный</label>
            </div>
            <input class="addAccountButton" id="addAccountButton" type="submit" name="addAccountButton" value="Добавить счет">
        </form>
    </div>
    <script type="text/javascript" src="../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>