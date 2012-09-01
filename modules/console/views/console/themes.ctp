<h2><?php __('Themes') ?></h2>

<?php foreach($themes as $name=>$theme) { ?>
	<div class="theme<?php if($name == $current) echo " active"?>">
		<?php echo $html->link(
			'<div class="thumb">'.
				$html->image(@$theme['screenshot'], array('width'=>300), null, null, false).
			'</div>'.
			'<h3>'.@$theme['title'].'</h3>'
		, array('controller'=>'admin', 'action'=>'themes', $name), null, null, false) ?>
		<div class="description">
			<?php echo $textile->process(@$theme['description']); ?>
		</div>
		<p><strong>Author:</strong> <?php echo $html->link(@$theme['author'],'mailto:'.@$theme['authorEmail']); ?>
		<p><strong>Date:</strong> <?php echo @$theme['date'] ?>
	</div>
<?php } ?>
