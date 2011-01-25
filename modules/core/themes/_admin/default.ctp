<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body id="admin" class="<?php echo $this->params['controller'].' '.$this->params['action'] ?>">
	<div id="header">
		<h1><?php echo $html->link(__(@$layout_title, true), @$layout_redirect); ?></h1>


		<ul id="menu-main">
			<li id="site"><?php echo $html->link(__('Visit Site', true), '/', array('target'=>'_blank'))?></li>
			<?php echo $this->Theme->menu('admin'); ?>
		</ul>
		<div id="status-bar">
			<?php echo @$status; ?>
		</div>
		<br style="clear:both">
	</div>
	<?php $session->flash();?>
	<?php $session->flash('auth');?>

	<div id="sidebar-left">
		<?php echo @$navigation ?>
	</div>

	<div id="content">
		<?php $session->error();?>
		<?php echo $content_for_layout; ?>
	</div>

	<div id="sidebar-right">
		<?php echo @$widgets; ?>
	</div>
</body>
</html>