<div class="<?php echo $model ?>">
    <?php if (isset($data) && sizeof($data) > 0): ?>
        <?php foreach($data as $entry): ?>
            <?php $value = $model.$entry[$model]['id'].'before' ?>
            <?php if (isset($$value)) echo $$value ?>
            <div class="post">
                <h3><?php echo $html->link($entry[$model]['title'], array('controller'=>'viewer', 'action'=>'view', 'model'=>$model, 'slug'=>@$entry[$model]['slug'])) ?></h3>
                <?php $value = $model.$entry[$model]['id'].'before_content'; echo @$$value; ?>
                <?php if(isset($entry[$model]['content'])): ?>
                <div class="content">
                    <?php if(isset($entry[$model]['photo']) && !empty($entry[$model]['photo'])): ?>
                    <div class="photo float-left margin-10"><?php echo $this->Html->image($entry[$model]['photo']) ?></div>
                    <?php endif ?>

                    <?php echo $entry[$model]['content'] ?>
                </div>
                <?php endif ?>
                <?php $value = $model.$entry[$model]['id'].'after_content'; echo @$$value; ?>
                <div class="bottom">
                <?php $value = $model.$entry[$model]['id'].'bottom'; echo @$$value; ?>
                </div>
            </div>
            <?php $value = $model.$entry[$model]['id'].'after' ?>
            <?php if (isset($$value)) echo $$value ?>
        <?php endforeach ?>
    <?php else: ?>
        <?php __('No '.Inflector::tableize($model).' yet') ?>
    <?php endif ?>
</div>