<script src="<?php echo $html->url('/modules/dev/views/editor/sitemap.js') ?>"></script>
<?php
$menus = $this->viewVars['menus'];
unset($menus['admin']);
foreach ($menus as $menu=>$data) {
    foreach ($data as $title=>$options) {
        if (is_array($options)) {
            $menus[$menu][$title]['_link'] = '/editor/edit/'.$options['_link'];
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
        <?php echo $this->Theme->render_menu($data) ?>
        </ul>
        <div class="actions">
            <input class="add-menu-item" value="Добавить пункт меню...">
        </div>
    </div>
</div>
<?php endforeach ?>