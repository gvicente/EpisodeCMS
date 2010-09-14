<!DOCTYPE html>
<html>
<?php echo $headers; ?>
<body id="<?php echo($this->action)?>">
	<div id="header">
		<h1><?php echo $html->link(@$site_title, '/', array('target'=>'_blank')); ?></h1>

		<div class="holder">
			<ul id="menu-main">
				<li class="first"><?php echo $html->link(__('Visit Site', true), '/admin')?></li>
				<?php echo $this->element('menu'); ?>
			</ul>
		</div>

		<div id="status-bar">
			<?php echo @$status; ?>
		</div>
		<br style="clear:both">
	</div>
	<?php echo $session->flash();?>
	<?php echo $session->flash('auth');?>

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