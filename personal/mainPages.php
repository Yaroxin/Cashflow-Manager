<div class="mainPages">
    <?php if($_SESSION['logged_user'] != 'free'): ?>
        <?php foreach($modules as $module): ?>
            <div class="mainPage mainPageActive" onclick="window.location='modules/<?php echo $module['name']; ?>.php?filter=Month'">
                <div class="mainPageImg">
                    <img src="img/coin.png" alt="page">
                </div>
                <div class="mainPageName"><?php echo $module['title']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>