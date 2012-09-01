<div id="center">
<h2><?php __('Modules')?></h2>
<?php foreach($modules as $module=>$data) { ?>
	<div class="module <?php echo @$data['installed']?'installed':'notinstalled';?> <?php echo @$data['old']?'old':'';?>">
		<?php if(@$data['installed']) {?>
		<h3><?php echo $html->link(__($data['title'], true), array('controller'=>'admin', 'action'=>'browse', 'module'=>$module)) ?></h3>
		<?php } else {?>
		<h3><?php echo $data['title'] ?></h3>
		<?php }?>
		<div class="actions">
			<?php if(!@$data['installed']) {?>
				<?php echo $html->link('Activate', array('controller'=>'admin', 'action'=>'install', 'module'=>$module), array('class'=>'button')) ?>
			<?php } elseif(@$data['package']!='core') { ?>
				<?php echo $html->link('Deactivate', array('controller'=>'admin', 'action'=>'uninstall', 'module'=>$module), array('class'=>'button')) ?>
			<?php } ?>
			<?php if(@$data['old']) {?>
				<?php echo $html->link('Update', array('controller'=>'admin', 'action'=>'update', 'module'=>$module), array('class'=>'button')) ?>
			<?php } ?>
		</div>
		<div class="version">
			<?php echo (@$data['version'])?>
		</div>
		<div class="description">
			<?php
			if(@$data['installed'])
				echo $textile->process(__(@$data['content'], true));
			else	
				echo $textile->process(@$data['description']);
			?> 
		</div>
		<div class="icon">
			<?php
				$iconFile = '/modules/'.$module.'/public/icon.png';
				if(file_exists(ROOT.$iconFile)) 
					echo $html->image($iconFile); 
			?>
		</div>
	</div>
<?php } ?>
</div>