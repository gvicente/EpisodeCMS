<!DOCTYPE html>
<html>
<?php echo $headers; ?>
<body>
	<?php echo $javascript->link('/themes/razbakov/jquery.scrollTo-min')?>
	<script>
	var blur = false;
	$(function(){
	function centerBlock() {
		$('#content').css({left:parseInt($(document).width()/2)-parseInt($('#content').width()/2)})
	}
	
	<?php if(@$content_for_layout):?>
		$('body').css({"min-height":2000});
		window.scrollTo(0,377);
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
<div id="content">
	<h1>Aleksey Razbakov &mdash; web-designer, developer</h1>
	<p id="photo"><?php echo $this->Theme->image('photo.jpg')?></p>
	<p><em>Phone:</em> <a target="_blank" href="skype:+380939041715?call">+38 093 904-17-15</a></p>
	<p><em>E-mail:</em> <a target="_blank" href="mailto:razbakov.aleksey@gmail.com">razbakov.aleksey@gmail.com</a></p>
	<p>
		<a target="_blank" href="skype:aleksey.razbakov"><?php echo $this->Theme->image('skype.png')?></a>
		<a target="_blank" href="mailto:razbakov.aleksey@gmail.com"><?php echo $this->Theme->image('gmail.png')?></a>
		<a target="_blank" href="http://www.icq.com/people/237229788"><?php echo $this->Theme->image('icq.png')?></a>
		<a target="_blank" href="http://vkontakte.ru/razbakov"><?php echo $this->Theme->image('vkontakte.png')?></a>
		<a target="_blank" href="http://bruz.habrahabr.ru/"><?php echo $this->Theme->image('habrahabr.png')?></a>
	</p>
	<?php
		$data = $this->requestAction('/viewer/view/page/home');
		echo $this->element('../viewer/view', compact('data'));
	?>
	<br>
	<p><a href="http://episodecms.com/"><?php echo $this->Theme->image('episode.png')?></a></p>
	<ul id="menu">
        <?php echo $this->Theme->menu('main') ?>
        <li><a target="_blank" href="http://photo.razbakov.com">Photos</a></li>
    </ul>
	<?php if(@$content_for_layout):?>
	<div id="inner-content">
		<?php echo $content_for_layout?>
	</div>
	<?php endif;?>
</div>

	<a id="studio" href="http://web4life.com.ua/">
		<?php echo $this->Theme->image('web4life.png')?>
	</a>

	<?php echo $this->element('scripts');?>
</body>
</html>
