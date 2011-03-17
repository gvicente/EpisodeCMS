<div class="toolbar dev-editor">
    <a id="menu-save" href="#" class="button save"><?php __('Save') ?></a>
    <a id="menu-delete" href="#" class="button delete"><?php __('Remove') ?></a>
    <div id="menu-icon"></div>
    <div class="menu-wrapper">
        <label for="menu-title">
            <span>Название:</span>
            <input id="menu-title" tooltip="Название элемента меню" value="<?php echo $title ?>">
        </label>
        <label for="menu-url">
            <span>Адрес:</span>
            <input id="menu-url" value="/" disabled="disabled">
        </label>
        <label for="menu-url">
            <span>Модуль:</span>
            <input id="menu-module" value="/" type="hidden">
            <div id="dev-editor-selector" class="select tree">
                <ul>
                    <li class="filter-active"><a href="#">Some</a></li>
                    <li><a href="#">Some</a></li>
                    <li><a href="#">Some</a>
                        <ul>
                            <li><a href="#">Some</a></li>
                            <li><a href="#">Some</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Some</a></li>
                    <li><a href="#">Some</a></li>
                </ul>
            </div>
        </label>
    </div>
    <div class="menu-selector">
        <?php /*
        <div class="select">
            <ul>
                <li class="title <?php if(!isset($current['module'])):?>filter-active<?php endif ?>">
                <a href="#"><?php __('Module') ?></a>
                </li>
            <?php foreach($modules as $module=>$module_title): ?>
                <li class="<?php if(isset($current['module']) && $current['module'] == $module):?>filter-active<?php endif ?>"><a href="#" id="<?php echo $module ?>" class="dev-editor-module"><?php echo $module_title ?></a></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div class="select">
            <ul>
                <li class="title <?php if(!isset($current['model'])):?>filter-active<?php endif ?>">
                <a href="#"><?php __('Model') ?></a>
                </li>
            <?php foreach($models as $model=>$model_title): ?>
                <li class="<?php if(isset($current['model']) && $current['model'] == $model):?>filter-active<?php endif ?>"><a href="#" id="<?php echo $model ?>" class="dev-editor-model"><?php echo $model_title ?></a></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div class="select">
            <ul>
                <li class="title <?php if(!$current['controller']):?>filter-active<?php endif ?>">
                <a href="#"><?php __('Controller') ?></a>
                </li>
            <?php foreach($actions as $controller=>$description): ?>
                <li class="<?php if($current['controller'] == $controller):?>filter-active<?php endif ?>"><a href="#" id="<?php echo $controller ?>" class="dev-editor-controller"><?php echo $description['_title'] ?></a></li>
            <?php endforeach ?>
            </ul>
        </div>
        <div class="select">
            <ul>
                <li class="title <?php if(!$current['action']):?>filter-active<?php endif ?>">
                <a href="#"><?php __('Action') ?></a>
                </li>
            <?php foreach($actions as $controller=>$description): ?>
                <?php foreach($description as $action=>$params):?>
                    <?php if (is_array($params)): ?>
                    <li class="<?php if($current['action'] == $action):?>filter-active<?php endif ?> controller-<?php echo $controller ?>"><a href="#" id="<?php echo $action ?>" class="dev-editor-action"><?php echo $params['_title'] ?></a></li>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endforeach ?>
            </ul>
        </div>
        */
        ?>
        
    </div>
    <div class="menu-options">
        
    </div>
    <br class="clear">
</div>

<div id="editor-content">
    
</div>