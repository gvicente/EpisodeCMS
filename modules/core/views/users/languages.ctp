<div id="admin-language">
	<?php foreach(array('rus', 'eng') as $lang):?>
		<?php echo $html->link($lang, array('controller'=>'users', 'action'=>'language', $lang), array('class' => $this->viewVars['language']==$lang?'active':''))?>
	<?php endforeach;?>
</div>