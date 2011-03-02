<h2><?php __('Comments') ?> (<?php echo sizeof($comments) ?>)</h2>
<?php foreach($comments as $comment): ?>
<div id="comment-<?php echo $comment['Comment']['id'] ?>" class="comment">
    <?php echo $comment['Comment']['content'] ?>
</div>
<?php endforeach ?>

<div class="comment-add">
    <?php echo $this->Form->create('Comment', array('action'=>'add')) ?>
    <?php echo $this->Form->input('parent', array('value'=>$parent, 'type'=>'hidden')) ?>
    <?php echo $this->Form->textarea('Comment.content', array('class'=>'comment-content', 'placeholder'=>__('Add your comment', true))) ?>
    <?php echo $this->Form->end('Add Comment') ?>
</div>