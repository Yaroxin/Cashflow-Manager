<?php
    require "../../db.php"; 
    require "../../config.php";

    session_start();

    if(isset($_SESSION['logged_user'])):
?>
<?php
    require "../userDB.php";
    $accounts = R::find('account', 'status != ?', [2]);
    $incomeCategory = R::findAll('incomecategory');    
?>

<!DOCTYPE html>
<html lang="en">
<?php include "../head.php"; ?>
<body>  
    <div class="wrap">
        <?php include_once "../topBar.php"; ?>
        <form id="addIncomeForm" class="addIncomeForm" action="" method="POST"> 
            <input id="addIncomeDate" class="addIncomeDate" type="date" name="addIncomeDate" value="<?php echo date("Y-m-d")?>" required>       
            
            <select id="chooseCat" class="addIncomeSelect" name="addIncomeCat" require onchange="chooseCategory(this);">
                <option value="0" disabled selected style='display:none;'>Категория</option>
                <?php if($incomeCategory): ?>
                    <?php foreach($incomeCategory as $cat): ?>
                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select> 

            <select id="chooseSubCat" class="addIncomeSelect" name="addIncomeSubCat" disabled>
                <option value="0" disabled selected style='display:none;'>Нет под категории</option>
            </select>

            <select id="addIncomeAccount" class="addIncomeSelect" name="addIncomeAccount" require onchange="accChoose(this);">                
                <option value="0" disabled selected style='display:none;'>Счет</option>
                <?php if($accounts): ?>
                <?php foreach($accounts as $acc): ?>
                <option value="<?php echo $acc['id'] ?>"><?php echo $acc['name'] ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <div class="addIncomeSummBlock">
                <input class="addIncomeInput addIncomeSumm" type="text" name="addIncomeSumm" placeholder="Сумма" inputmode="decimal" maxlength="10" required>
                <input id="addCurrency" class="addIncomeInput addIncomeCurrency" type="text" name="addIncomeCurrency" placeholder="RUB" disabled>
                <input id="addCurrencyId" type="hidden" name="addIncomeCurrencyId" value="3">
            </div>
            <textarea name="addIncomeNote" id="addIncomeNote" rows="5" maxlength="300" wrap="hard"></textarea>
            <input class="addIncomeButton" id="addIncomeButton" type="submit" name="addIncomeButton" value="Добавить доход">
        </form>
    </div>
    <script type="text/javascript" src="../../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>