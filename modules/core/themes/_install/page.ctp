<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
	<script>
	$(function(){
		$('.button').each(function(){
			$(this).prepend('<span>');
		});

		$('#menu-main li').each(function(){
			var $this = $(this);
			if($('ul li', $this).length>0)
				$this.addClass('childs');
		});
	})
	</script>
</head>
<body id="admin" class="<?php echo $this->params['controller'].'-controller '.$this->params['action'] ?>-action">
	<div id="header">
		
	</div>
    <br style="clear:both">
	<?php echo $session->flash();?>
	<?php echo $session->flash('auth');?>

	<div id="sidebar-left">
		<?php echo $this->Theme->widget('navigation', $this) ?>
	</div>

	<div id="content">

		<?php $session->error();?>
		<?php echo $content_for_layout; ?>
	</div>

	<div id="sidebar-right">
        <?php echo $this->Theme->widget('widgets', $this) ?>
	</div>
</body>
</html>