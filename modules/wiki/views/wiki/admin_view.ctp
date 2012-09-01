<h2>
<?php echo $current_title ?> 
<?php echo $this->Html->link(__('Edit', true), array('action'=>'admin_edit', 'title'=>$title), array('class'=>'button edit')) ?> 
<?php echo $this->Html->link(__('Remove', true), array('action'=>'admin_delete', 'title'=>$title), array('class'=>'button delete')) ?>
</h2>
<div class="wiki content">
    <?php echo $this->Wiki->process($wiki['Wiki']['content']) ?>
</div>