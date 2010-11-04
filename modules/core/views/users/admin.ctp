<div id="admin-user-info">
	<?php echo String::insert(
		__('You logined as :name',true), 
		array(
			'name' => $html->link(
						$user['username'], 
						array(
							'controller'=>'admin', 
							'action'=>'edit',
							'module'=>'core',
							'model'=>'User', 
							'id'=>$user['id']
						)
					)
			)
		) ?>
	<a id="logout" class="button" href="<?php echo $html->url('/logout')?>"><?php __('Logout')?></a>
</div>