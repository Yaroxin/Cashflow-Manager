<?php
    require "db.php";
    require "config.php";
    require "auth.php";
    require "functions.php";
    if(!isset($_SESSION['logged_user'])):
?>
<?php require "login.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <title><?php echo $APP_NAME; ?></title>
</head>
<body>  
    <div class="wrap">
    <div class="topDecor"></div>
        <div class="topBar">
            <div class="appName"><?php echo $APP_NAME .' '. $APP_VERSION; ?></div>    
        </div>       
        <div id="mainWindow" class="mainWindow">            
            <div class="mainInfoBlock">                
                <div class="loginBlock">    
                    <div class="loginArea">
                        <?php if(!empty($errors)): ?>
                        <div class="errorsBar"><?php echo array_shift($errors); ?></div>
                        <?php endif; ?>
                        <form class="LoginForm" action="" method="POST">
                            <input class="LoginInput" type="text" name="email" required placeholder="E-mail or Login">
                            <input class="LoginInput" type="password" name="password" required placeholder="Password">
                            <div class="rememberBlock">
                                <input id="remember" type="checkbox" name="remember" checked>
                                <label for="remember">Запомнить меня</label>
                            </div>
                            <input class="LoginButton" type="submit" name="login" value="Войти">
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <script type="text/javascript" src="scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>
<?php else: header('location: /personal/home.php') ?>
<?php endif; ?>