<!DOCTYPE html>
<html>
<head>
	<?php echo $headers ?>
</head>
<body>
	<div id="header">
		<ul id="main-menu">
		    <?php echo $theme->menu('main') ?>
		</ul>
	</div>
	<div id="main">
		<ul id="breadcrumbs">
			
		</ul>
		<div id="content">
		    <?php echo $content_for_layout ?>
            <?php echo $theme->widget('newsletter/newsletter') ?>
        </div>
        <div id="sidebar">
            <?php if(!$user) echo $theme->widget('users/login') ?>
        </div>
    </div>
</body>
</html>