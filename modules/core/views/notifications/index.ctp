<script>
	$(function(){
		$('.notifications').promoSlider({slider:'.notification', auto:false});
	});

    function clear_todo_field() {
        var $text = $('.text', $(this));
        var $this = $(this);
        var html = $text.html();
        $this.removeClass('active');
        if (html == '' || html == '<br>') {
            $text.html($this.attr('default'));
        } else {
            if(!$this.data('cloned')) {
                var new_template = template.clone(true);
                $this.before(new_template);
                $this.data('cloned', true);
                $this.prepend('<span class="delete">x</span>');
            }
        }
    }

    $('.todo').each(clear_todo_field);
    var template = $('.todo:first').clone(true);

    $('.todo').live('blur', clear_todo_field);

    $('.todo').live('click', function() {
        var $text = $('.text', $(this));
        var $this = $(this);
        var html = $text.html();
        if (html == $this.attr('default')) {
            $text.html('');
        }

        $this.addClass('active');
        $text.focus();
    });

    $('.todo .delete').live('click', function() {
        $(this).parent().remove();
        return false;
    });
</script>
<div id="center">
	<h2><?php __('Dashboard') ?></h2>
    <div id="wall">
    <div class="todo" default="Желаете что-то сделать? Нажмите здесь и начните набирать текст...">
        <div class="text" contenteditable="true"></div>
    </div>
</div>
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