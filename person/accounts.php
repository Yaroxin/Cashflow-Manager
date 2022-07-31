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
    <div class="topNavBar">
        <div class="homeLink" onclick="document.location.href = 'main.php';">Home</div>
        <div class="pageTitle">Accounts</div>
        <div class="addLink" id="addLink">Add</div>
    </div>

    <div class="addNewAccount hide" id="addNewAccount">
        <div class="addLine">                                
            <div class="accName addAccName">
                <div class="accTitle">
                    <input class="addInputTitle" type="text" placeholder="Account name">
                </div>
            </div>
            <div class="accBalance">
                <div class="accSum">
                    <input class="addInputBalance" type="text" placeholder="27 827,52">
                </div>
            </div>
            <div class="accCurrency">
                <select class="addAccCurrency" name="addAccCurrency" id="addAccCurrency">
                    <option value="RUB">&#8381;</option>
                    <option value="USD">&#36;</option>
                    <option value="EUR">&#128;</option>
                </select>
            </div>
        </div>
        <div class="addLine">
            <div class="imgBlock addImgBlock">
                <input type="hidden" name="accIcoId" value="1">
            </div>

            <select class="addAccGroup" name="accGroup" id="accGroup">
                <option value="Chase">CHASE</option>
                <option value="BankOfAmerica">Bank of America</option>
            </select>
            <div class="addCheckbox">
                <div class="accInBalance">
                    <input type="checkbox" id="accInBalance" name="accInBalance" value="1" checked>
                    <label for="accInBalance"> In Balance</label>
                </div>
                <div class="accIsCredit">
                    <input type="checkbox" id="accIsCredit" name="accIsCredit" value="0">
                    <label for="accIsCredit"> Is Credit</label>
                </div>
            </div>         
        </div>
        <div class="addLine">
            <textarea name="accountNote" id="accountNote" cols="60" rows="5" placeholder="Account note"></textarea>
        </div>

        <div class="addButtons">
            <input type="button" name="cancelAccountBtn" id="cancelAccountBtn" value="Cancel">
            <input type="submit" name="addAccountBtn" id="addAccountBtn" value="Add Account">            
        </div>


    </div>


    <div class="accBlock" id="accBlock">
        <div class="account">
            <div class="accRight">
                <div class="imgBlock">
                    <img src="/person/accountico/default.png" alt="">
                </div>                
                <div class="accName">
                    <div class="accTitle">Cash</div>
                    <div class="accGroup"></div>
                </div>
            </div>            
            <div class="accBalance">
                <div class="accSum">27 827,52 &#8381;</div>
                <div class="accInBalance">In balance</div>
            </div>
        </div>
        <div class="account">
            <div class="accRight">
                <div class="imgBlock">
                    <img src="/person/accountico/default.png" alt="">
                </div>                
                <div class="accName">
                    <div class="accTitle">Debit Card</div>
                    <div class="accGroup">Chase</div>
                </div>
            </div>            
            <div class="accBalance">
                <div class="accSum">148 002,00 &#8381;</div>
                <div class="accInBalance">Out of balance</div>
            </div>
        </div>
        <div class="account">
            <div class="accRight">
                <div class="imgBlock">
                    <img src="/person/accountico/default.png" alt="">
                </div>                
                <div class="accName">
                    <div class="accTitle">Cash</div>
                    <div class="accGroup"></div>
                </div>
            </div>            
            <div class="accBalance">
                <div class="accSum">27 827,52 &#8381;</div>
                <div class="accInBalance">In balance</div>
            </div>
        </div>        
    </div>




    <div class="itemsBlock">
        <div class="homeItem homeItemActive">
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
<?php include_once 'getScripts.php'; ?>
</body>
</html>

<?php else: header('location: /') ?>
<?php endif; ?>