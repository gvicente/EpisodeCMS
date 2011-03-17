<!doctype html>
<html>
<head>
    <?php echo $headers ?>
</head>
<body>
    <div class="login">
        <?php if (!$user): ?>
            <?php echo $this->Theme->widget('users/login') ?>
        <?php else: ?>
            Logined as <?php echo $user['User']['username'] ?>
            <?php echo $html->link('Logout', '/users/logout') ?>
        <?php endif ?>
    </div>
    <div id="content">
        <?php echo $this->Theme->menu('main') ?>
        <?php echo $content_for_layout ?>
    </div>
</body>
</html> 