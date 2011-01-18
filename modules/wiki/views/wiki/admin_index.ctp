<h2>
<?php __('Wiki') ?> 
<?php echo $this->Html->link(__('Add', true), array('action'=>'admin_edit'), array('class'=>'button add')) ?>
</h2>
<div class="wiki content">
<ul>
<?php foreach($wikis as $wiki): ?>
    <li><?php echo $this->Html->link($wiki['Wiki']['title'], array('action'=>'admin_view', 'title'=>$wiki['Wiki']['title'])) ?></li>
<?php endforeach ?>
</ul>
</div>