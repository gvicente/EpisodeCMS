<?php
$menus = $this->viewVars['menus'];
unset($menus['admin']);
?>
<?php foreach ($menus as $menu=>$data): ?>
<div class="widget">
    <?php if(isset($data['_title'])): ?>
    <h2><?php __($data['_title']) ?></h2>
    <?php else: ?>
    <h2><?php __(Inflector::humanize($menu)) ?></h2>
    <?php endif ?>
    <div class="content menu">
        <ul>
        <?php echo $this->Theme->menu($menu) ?>
        </ul>
        <div class="actions">
            <input class="add-menu-item" value="Добавить пункт меню...">
        </div>
    </div>
</div>
<?php endforeach ?>