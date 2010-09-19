<div id="admin-language">
	<?php foreach(array('rus', 'eng') as $lang):?>
		<?php echo $html->link($lang, array('controller'=>'admin', 'action'=>'language', $lang), array('class'=>$language==$lang?'active':''))?>
	<?php endforeach;?>
</div>