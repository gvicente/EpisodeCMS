<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body>
    <h1>COOK2.ME</h1>
    
	<div id="header">
		<ul id="menu"><?php echo $this->element('menu')?></ul>
	</div>

	<div id="content" class="content">
		<?php echo $content_for_layout ?>
	</div>
	<?php echo $scripts_for_layout ?>
</body>
</html>