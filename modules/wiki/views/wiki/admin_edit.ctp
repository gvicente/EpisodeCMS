<div id="wiki-breadcrumbs">
    <?php echo $this->Html->link(__('Wiki', true), '/admin/wiki') ?>
    <?php if($title): ?>
    <?php echo $html->link($title, '/admin/wiki/view/'.$title) ?>
    <?php endif ?>
</div>
<?php echo $this->Form->create('Wiki', array('url'=>'/admin/wiki/edit/')) ?>
<input type="hidden" value="<?php echo $wiki['Wiki']['id'] ?>" name="data[Wiki][id]"/>
<h2>
    <input value="<?php echo $title ?>" name="data[Wiki][title]"/>
</h2>
<textarea name="data[Wiki][content]" class="editor"><?php echo $wiki['Wiki']['content'] ?></textarea>
<div class="submit">
    <?php if($title): ?>
    <?php echo $html->link(__('Cancel', true), '/admin/wiki/view/'.$title, array('class'=>'button cancel')) ?>
    <?php else: ?>
    <?php echo $html->link(__('Cancel', true), '/admin/wiki/', array('class'=>'button cancel')) ?>
    <?php endif ?>
    <button type="submit" class="button save"><?php echo __('Save', true)?></button>
</div>
<?php $this->Form->end('') ?>