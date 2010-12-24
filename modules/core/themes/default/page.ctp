<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body>
	<div id="header">
		<?php echo $html->image('/modules/core/public/logo.png', array('url'=>'/')); ?>
		<ul id="menu"><?php echo $this->Theme->menu('main')?></ul>
	</div>

	<div id="content" class="content">
		<?php echo $content_for_layout ?>
	</div>
	<?php echo $scripts_for_layout ?>
</body>
</html>