<?php
    require "../db.php"; 
    require "../config.php";
       

    session_start();    
    if(isset($_SESSION['logged_user'])):
?>
<?php
    require "userDB.php"; 

    if($_SESSION['logged_user']['status'] == 'free'){
        $currencies = R::find('currency', 'status = ?', [$_SESSION['logged_user']['status']]);
    }
    if($_SESSION['logged_user']['status'] == 'premium'){
        $currencies = R::findAll('currency');
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
        <form id="addAccountForm" class="addAccountForm" action="" method="POST">
            <input class="addAccountInput" type="text" name="accName" required placeholder="Название счета" maxlength="64">
            <input class="addAccountInput" type="text" name="accStartBalance" required placeholder="Начальный баланс" inputmode="decimal" maxlength="16">
            <select class="accCurrency" name="accCurrency" id="accCurrency" require>
                <option value="" disabled selected style='display:none;'>Валюта счета</option>
                    <?php foreach($currencies as $currency): ?>
                        <option value="<?php echo $currency['id'] ?>"><?php echo $currency['lettcode'] ?></option>
                    <?php endforeach; ?>             
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