<h2><?php __('Menus') ?></h2>

<?php if(@$menus) :?>
<ul id="menu-management">
	<?php foreach($menus as $id=>$menu) { ?>
		<li class="menu">
		<h3><?php echo $menu ?></h3>
		<?php if(@$links[$id]) :?>
			<?php echo $this->element('menu', array('menu'=>$links[$id])); ?>
		<?php else: ?>
			Empty
		<?php endif;?>
		</li>	
	<?php }?>
</ul>
<?php else: ?>
	This theme doesn't support menus.
<?php endif; ?>
