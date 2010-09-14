<div class="<?php echo $model ?>">
<?php 
if(@$data)
foreach($data as $entry) { ?>
	<?php $value = $model.$entry[$model]['id'].'before'; echo @$$value; ?>
	<div class="post">
		<h3><?php echo $html->link($entry[$model]['title'], array('controller'=>'viewer', 'action'=>'view', 'model'=>$model, 'slug'=>@$entry[$model]['slug'])) ?></h3>
		<?php $value = $model.$entry[$model]['id'].'before_content'; echo @$$value; ?>
		<div class="content"><?php echo $entry[$model]['content'] ?></div>
		<?php $value = $model.$entry[$model]['id'].'after_content'; echo @$$value; ?>
		<div class="bottom">
		<?php $value = $model.$entry[$model]['id'].'bottom'; echo @$$value; ?>
		</div>
	</div>
	<?php $value = $model.$entry[$model]['id'].'after'; echo @$$value; ?>
<?php } ?>
</div>