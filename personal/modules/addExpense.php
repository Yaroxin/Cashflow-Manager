<?php
    require "../../db.php"; 
    require "../../config.php";

    session_start();

    if(isset($_SESSION['logged_user'])):
?>
<?php
    require "../userDB.php";
    $accounts = R::find('account', 'status != ?', [2]);
    $expenseCategory = R::find('expensecategory', 'status != ?', [2]);    
?>

<!DOCTYPE html>
<html lang="en">
<?php include "../head.php"; ?>
<body>  
    <div class="wrap">
        <?php include_once "../topBar.php"; ?>
        <form id="addExpenseForm" class="addExpenseForm" action="" method="POST"> 
            <input id="addExpenseDate" class="addExpenseDate" type="date" name="addExpenseDate" value="<?php echo date("Y-m-d")?>" required>       
            
            <select id="chooseCat" class="addExpenseCat" name="addExpenseCat" require onchange="chooseCategory(this);">
                <option value="0" disabled selected style='display:none;'>Категория</option>
                <?php if($expenseCategory): ?>
                    <?php foreach($expenseCategory as $cat): ?>
                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select> 

            <select id="chooseSubCat" class="addExpenseSubCat" name="addExpenseSubCat" disabled>
                <option value="0" disabled selected style='display:none;'>Нет под категории</option>
            </select>

            <select id="addExpenseAccount" class="addExpenseSelect" name="addExpenseAccount" require onchange="accChoose(this);">                
                <option value="0" disabled selected style='display:none;'>Счет</option>
                <?php if($accounts): ?>
                <?php foreach($accounts as $acc): ?>
                <option value="<?php echo $acc['id'] ?>"><?php echo $acc['name'] ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <div class="addExpenseSummBlock">
                <input class="addExpenseInput addExpenseSumm" type="text" name="addExpenseSumm" placeholder="Сумма" inputmode="decimal" maxlength="10" required>
                <input id="addCurrency" class="addExpenseInput addExpenseCurrency" type="text" name="addExpenseCurrency" placeholder="RUB" disabled>
                <input id="addCurrencyId" type="hidden" name="addExpenseCurrencyId" value="3">
            </div>
            <textarea name="addExpenseNote" id="addExpenseNote" rows="5" maxlength="300" wrap="hard"></textarea>
            <input class="addExpenseButton" id="addExpenseButton" type="submit" name="addExpenseButton" value="Добавить расход">
        </form>
    </div>
    <script type="text/javascript" src="../../scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../scripts/index.js"></script>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>