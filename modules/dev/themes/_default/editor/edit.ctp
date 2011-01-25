<div class="toolbar dev-editor">
    <a id="menu-save" href="#" class="button save"><?php __('Save') ?></a>
    <a id="menu-delete" href="#" class="button delete"><?php __('Remove') ?></a>
    <div id="menu-icon"></div>
    <div class="menu-wrapper">
        <label for="menu-title">
            <span>Название:</span>
            <input id="menu-title" value="<?php echo $title ?>">
        </label>
        <label for="menu-url">
            <span>Адрес:</span>
            <input id="menu-url" value="/" disabled="disabled">
        </label>
    </div>
    <div class="menu-selector">
        <div id="dev-editor-modules" class="dev-editor-select">
            <ul class="dev-editor-options">
                <li class="title <?php if(!isset($current['module'])):?>active<?php endif ?>">
                <span><?php __('Module') ?></span>
                </li>
            <?php foreach($modules as $module=>$module_title): ?>
                <li class="<?php if(isset($current['module']) && $current['module'] == $module):?>active<?php endif ?>"><span id="<?php echo $module ?>" class="dev-editor-module"><?php echo $module_title ?></span></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div id="dev-editor-models" class="dev-editor-select">
            <ul class="dev-editor-options">
                <li class="title <?php if(!isset($current['model'])):?>active<?php endif ?>">
                <span><?php __('Model') ?></span>
                </li>
            <?php foreach($models as $model=>$model_title): ?>
                <li class="<?php if(isset($current['model']) && $current['model'] == $model):?>active<?php endif ?>"><span id="<?php echo $model ?>" class="dev-editor-model"><?php echo $model_title ?></span></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div id="dev-editor-controllers" class="dev-editor-select">
            <ul class="dev-editor-options">
                <li class="title <?php if(!$current['controller']):?>active<?php endif ?>">
                <span><?php __('Controller') ?></span>
                </li>
            <?php foreach($actions as $controller=>$description): ?>
                <li class="<?php if($current['controller'] == $controller):?>active<?php endif ?>"><span id="<?php echo $controller ?>" class="dev-editor-controller"><?php echo $description['_title'] ?></span></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div id="dev-editor-actions" class="dev-editor-select">
            <ul class="dev-editor-options">
                <li class="title <?php if(!$current['action']):?>active<?php endif ?>">
                <span><?php __('Action') ?></span>
                </li>
            <?php foreach($actions as $controller=>$description): ?>
                <?php foreach($description as $action=>$params):?>
                    <?php if (is_array($params)): ?>
                    <li class="<?php if($current['action'] == $action):?>active<?php endif ?> controller-<?php echo $controller ?>"><span id="<?php echo $action ?>" class="dev-editor-action"><?php echo $params['_title'] ?></span></li>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="menu-options">
        
    </div>
    <br class="clear">
</div>

<div id="editor-content">
    
</div>