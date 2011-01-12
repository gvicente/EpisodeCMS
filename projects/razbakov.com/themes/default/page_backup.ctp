<!DOCTYPE html>
<html>
<?php echo $headers; ?>
<body>
	<?php echo $javascript->link('/themes/razbakov/jquery.scrollTo-min')?>
	<?php echo $javascript->link('/themes/razbakov/supersized.2.0')?>
	<?php //echo $javascript->link('/themes/razbakov/pixastic.custom')?>
	<script>
	var blur = false;
	$(function(){
	if(blur) {
		var img = document.getElementById("background");

		if (img.complete)
			var newimg = Pixastic.process(img,"blurfast", {amount : 5});
	} else {
		$('#supersize').supersized();
	}

	function centerBlock() {
		$('#content').css({left:parseInt($(document).width()/2)-parseInt($('#content').width()/2)})
	}	
	<?php if(@$content_for_layout):?>
		$('body').css({"min-height":2000});
		window.scrollTo(0,355);
		function updatePosition() {
			if($(document).width()>1110)
				$('#uapub').show();
			else
				$('#uapub').hide();
			centerBlock();
		}
	<?php else:?>
		function updatePosition() {
			var top = parseInt($(document).height()/2) - parseInt($('#content').height()/2);
			$('#content').css({"top":top});
			if($(document).width()>1110)
				$('#uapub').show();
			else
				$('#uapub').hide();
			centerBlock();
		}
	<?php endif;?>
	updatePosition();
	$(window).resize(updatePosition);
	})
	</script>
<div id="supersize"> 
	<?php echo $html->image('/themes/razbakov/images/bg.jpg', array('id'=>'background')); ?>
</div> 
<div id="content">
	<?php if(@$content_for_layout):?>
	<h1><?php echo $html->link('← На главную', '/')?></h1>
	<?php else:?>
	<h1>Алексей Разбаков &mdash; веб-дизайнер, программист</h1>
	<?php endif;?>
	<p><?php echo $html->image('/themes/razbakov/images/photo.jpg')?></p>
	<p><em>Телефон:</em> <a target="_blank" href="skype:+380939041715?call">+38 093 904-17-15</a></p>
	<p><em>Электро-почта:</em> <a target="_blank" href="mailto:razbakov.aleksey@gmail.com">razbakov.aleksey@gmail.com</a></p>
	<p>
		<a target="_blank" href="skype:aleksey.razbakov"><?php echo $html->image('/themes/razbakov/images/skype.png')?></a>
		<a target="_blank" href="mailto:razbakov.aleksey@gmail.com"><?php echo $html->image('/themes/razbakov/images/gmail.png')?></a>
		<a target="_blank" href="http://www.icq.com/people/237229788"><?php echo $html->image('/themes/razbakov/images/icq.png')?></a>
		<a target="_blank" href="http://vkontakte.ru/razbakov"><?php echo $html->image('/themes/razbakov/images/vkontakte.png')?></a>
		<a target="_blank" href="http://bruz.habrahabr.ru/"><?php echo $html->image('/themes/razbakov/images/habrahabr.png')?></a>
	</p>
	<?php
		$data = $this->requestAction('/viewer/view/page/home');
		echo $this->element('../viewer/view', compact('data'));
	?>
	<br>
	<p><a href="http://razbakov.com/episode/"><?php echo $html->image('/themes/razbakov/images/episode.png')?></a></p>
	<ul id="menu"><?php echo $this->element('menu')?></ul>
	<?php if(@$content_for_layout):?>
	<div id="inner-content">
		<?php echo $content_for_layout?>
	</div>
	<?php endif;?>
</div>

	<a id="uapub" href="http://razbakov.com:777/">
		<?php echo $html->image('/themes/razbakov/images/uapub.png')?>
		<h2 style="text-align:center;margin-top:5px;">Дизайн-студия «UApub»</h2>
	</a>

	<?php echo $this->element('scripts');?>
</body>
</html>
