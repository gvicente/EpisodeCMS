<h2><?php echo $data['entry'][$data['model']]['title'] ?></h2>
<div class="post">
	<div class="content"><?php echo $data['entry'][$data['model']]['content'] ?></div>
</div>
<?php echo $this->Theme->wrapper($data['model'].'after', $this) ?>
<?php echo $this->Theme->wrapper('viewerafter', $this) ?>
