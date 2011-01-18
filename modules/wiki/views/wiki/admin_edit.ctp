<?php echo $this->Form->create('Wiki', array('url'=>'/admin/wiki/edit/')) ?>
<input type="hidden" value="<?php echo $wiki['Wiki']['id'] ?>" name="data[Wiki][id]"/>
<input type="hidden" value="<?php echo $parent_id ?>" name="data[Wiki][parent_id]"/>
<input type="hidden" value="<?php echo $redirect ?>" name="data[redirect]"/>
<h2>
    <input value="<?php echo $current_title ?>" name="data[Wiki][title]"/>
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