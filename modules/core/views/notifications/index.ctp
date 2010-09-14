<script>
	$(function(){
		$('.notifications').promoSlider({slider:'.notification', auto:false});
	});
</script>
<div id="center">
	<h2><?php __('Dashboard') ?></h2>
	<?php if(empty($data)): ?>
	
	<?php else: foreach($data as $object=>$entries):?>
		<div class="module">
			<h3><a href="#"><?php echo str_replace('%', sizeof($entries), $notifications[$object]['text'])?></a></h3>
			<div class="actions">
				<?php echo $html->link('Delete notification', array('controller'=>'notifications', 'action'=>'delete', 'id'=>$ids[$object]), array('class'=>'button')); ?>
			</div>
			<div class="description">
				<?php echo $textile->process($notifications[$object]['content']);?>				
			</div>
			<div class="icon">
				<?php
					$iconFile = $notifications[$object]['icon'];
					if(file_exists(ROOT.$iconFile)) 
						echo $html->image($iconFile);
				?>
			</div>
			<div class="notifications" id="notificationsOn<?php echo $object?>">
				<?php foreach($entries as $entry): ?>
					<div class="notification">
						<?php echo $entry['Sender']['User']['username'] ?> » <em><?php echo $entry['Object']['Post']['title'] ?></em> 
						<em><?php echo $entry['Text']['Comment']['content'] ?></em>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>