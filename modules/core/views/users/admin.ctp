<div id="admin-user-info">
	<?php echo String::insert(__('You logined as :name',true), array('name' => '<a>admin</a>')) ?>
	<a id="logout" class="button" href="<?php echo $html->url('/logout')?>"><?php __('Logout')?></a>
</div>