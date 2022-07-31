<?php
    require 'db.php';

    $_SESSION['logged_user']['name'] = 'yaroxin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><title>MyWallet</title>
</head>
<body>
    <a href="\person\main.php">Enter - <?php echo $_SESSION['logged_user']['name']; ?></a>
</body>
</html>