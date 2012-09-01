<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body>
    <div id="page">
        <div id="header">
            <h1><?php echo $this->Html->link('Site Title', '/') ?></h1>
            <div id="menu-main">
                <ul>
                    <?php echo $this->Theme->menu('main')?>
                </ul>
            </div>
        </div>
        <div id="content">
            <?php echo $content_for_layout ?>
        </div>
    </div>
    <div id="footer">
        © 2010. Powered by <a href="http://episodecms.com">EpisodeCMS</a>.
    </div>
    <?php echo $scripts_for_layout ?>
</body>
</html>