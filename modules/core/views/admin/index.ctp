<script>
$(function(){
    $(".notinstalled").hide();

    var html = $("#center h2").html();

    html = html
        + ' <span class="devider"></span>'
        + ' <a href="#" id="installed" class="active"><span></span>' + __('Installed') + '</a>'
        + ' <a href="#" id="notinstalled"><span></span>' + __('Not Installed') + '</a>'
        + ' <a href="#" id="available"><span></span>' + __('Available') + '</a>'
        + ' <a href="#" id="create"><span></span>' + __('Create New') + '</a>';
        
    $("#center h2").html(html);
    
    $("#center h2 a").click(function(){
        var id = $(this).attr('id');
        $('#modules .module').hide();
        $('.' + id).show();
        $('h2 a').removeClass('active');
        $(this).addClass('active');
        return false;
    });
})
</script>
<div id="center">
<div class="module project">
    <div class="description">
        <?php echo $textile->process(__($config['description'], true)) ?>
    </div>
    <div class="icon">
        <?php
            $iconFile = '/projects/'.$config['project'].'/public/icon.png';
            if(file_exists(ROOT.$iconFile))
                echo $html->image($iconFile);
        ?>
    </div>
</div>
<div id="modules">
<h2><?php __('Modules') ?></h2>
<div class="container">
<?php foreach ($modules as $module=>$data): ?>
	<div class="module <?php echo $data['installed']?'installed':'notinstalled' ?> <?php echo $data['old']?'old':'' ?>">
		<?php if ($data['installed']): ?>
		<h3><?php echo $html->link($data['title'], array('controller'=>'admin', 'action'=>'customize', 'module'=>$module)) ?></h3>
		<?php else:?>
		<h3><?php echo $data['title'] ?></h3>
		<?php endif ?>
		<div class="actions">
			<?php if (!$data['installed']):?>
				<?php echo $html->link(__('Activate', true), array('controller'=>'admin', 'action'=>'install', 'module'=>$module), array('class'=>'button activate')) ?>
			<?php elseif ($data['package'] != 'core'): ?>
				<?php echo $html->link(__('Deactivate', true), array('controller'=>'admin', 'action'=>'uninstall', 'module'=>$module), array('class'=>'button deactivate')) ?>
			<?php endif ?>
			<?php if ($data['old']): ?>
				<?php echo $html->link(__('Update', true), array('controller'=>'admin', 'action'=>'update', 'module'=>$module), array('class'=>'button update')) ?>
			<?php endif ?>
		</div>
		<div class="version">
            <?php echo $data['intro']['version'] ?>
		</div>
		<div class="description">
			<?php
			if($data['installed'])
				echo $textile->process(__($data['content'], true));
			else	
				echo $textile->process($data['description']);
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
<?php endforeach ?>
</div>
</div>
</div>