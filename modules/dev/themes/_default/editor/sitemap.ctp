<?php
$menus = Configure::read('menus');
unset($menus['admin']);
foreach ($menus as $menu=>$data) {
    foreach ($data as $title=>$options) {
        if (is_array($options)) {
            $menus[$menu][$title]['_link'] = '/editor/edit/'.$menu.'/'.$options['_link'];
        }
    }
}
?>
<?php foreach ($menus as $menu=>$data): ?>
<div class="widget" widget="dev-editor-sitemap">
    <?php if(isset($data['_title'])): ?>
    <h2><?php __($data['_title']) ?></h2>
    <?php else: ?>
    <h2><?php __(Inflector::humanize($menu)) ?></h2>
    <?php endif ?>
    <div class="content menu">
        <ul>
        <?php echo $this->Theme->render_menu($data, array('rel'=>'ajax')) ?>
        </ul>
        <div class="actions">
            <input class="add-menu-item" value="Добавить пункт меню...">
        </div>
    </div>
</div>
<?php endforeach ?>