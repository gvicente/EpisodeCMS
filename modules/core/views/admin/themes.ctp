<h2><?php __('Themes') ?></h2>

<?php foreach($themes as $name=>$theme): ?>
	<div class="theme<?php if($name == $current) echo " active"?>">
		<a href="<?php echo $html->url(array('controller'=>'admin', 'action'=>'themes', $name))?>">
			<div class="thumb">
                <?php if($theme['screenshot']): ?>
                    <?php echo $html->image($theme['screenshot'], array('width'=>300))?>
                <?php else: ?>
                    <div class="no-screenshot">
                        <?php __("No Screenshot") ?>
                    </div>
                <?php endif ?>
			</div>
			<h3><?php echo @$theme['title'] ?></h3>
		</a>
		<p><strong>Author:</strong> <?php echo $html->link(@$theme['author'],'mailto:'.@$theme['authorEmail']); ?>
		<p><strong>Date:</strong> <?php echo @$theme['date'] ?>
	</div>
<?php endforeach // foreach($themes as $name=>$theme) ?>
