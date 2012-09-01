<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body id="admin" class="<?php echo $this->params['controller'].'-controller '.$this->params['action'] ?>-action">
	<div id="header">
		<div class="holder">
            <h1><?php echo $html->link(@$site_title, '/', array('target'=>'_blank')); ?></h1>
            <?php echo $this->Theme->wrapper('status', $this, 'status-bar') ?>
		</div>
	</div>
    <br style="clear:both">
	<?php echo $session->flash();?>
	<?php echo $session->flash('auth');?>

	<div id="sidebar-left">
        <ul id="menu-main">
            <?php echo $this->Theme->menu('admin') ?>
        </ul>

		<?php echo $this->Theme->wrapper('navigation', $this) ?>
	</div>

	<div id="content">
        <?php echo $this->Theme->breadcrumbs(' → ') ?>
		<?php echo $session->error(); ?>
		<?php echo $content_for_layout; ?>
	</div>

	<div id="sidebar-right">
        <?php echo $this->Theme->wrapper('widgets', $this) ?>
	</div>
</body>
</html>