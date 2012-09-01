<div id="admin-user-info">
    <?php echo String::insert(
		__('You logined as :name',true), 
		array(
			'name' => $html->link(
						$this->viewVars['user']['User']['username'],
						array(
							'controller'=>'admin', 
							'action'=>'edit',
							'module'=>'core',
							'model'=>'User', 
							'id'=>$this->viewVars['user']['User']['id']
						)
					)
			)
		) ?>
	<a id="logout" class="button" href="<?php echo $html->url('/logout')?>"><?php __('Logout')?></a>
</div>