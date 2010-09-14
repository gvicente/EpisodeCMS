<div class="widget">
	<h2><?php echo $html->link(Inflector::camelize(Inflector::pluralize($model)), array('controller'=>'admin', 'action'=>'browse', 'model'=>$model, 'module'=>$module)) ?></h2>
	<div class="content">
	<ul class="filter">
	<?php if(@$data) {
	foreach($data as $key=>$entry) { if($entry[$model]['slug']):?>
		<li class="row <?php echo ($key % 2==0?"even":"odd") ." ". ($key == sizeof($data)-1?"last":($key == 0?"first":"")) ?>">
			<?php echo $filter->link($entry[$model][$maincolumn], $model, $entry[$model]['slug'])?> 
		</li>
	<?php endif; }} else { ?>
		<div>No <?php echo Inflector::pluralize($model) ?>.</div>
	<?php } ?>
	</ul>
	</div>
</div>