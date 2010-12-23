<script>
	$(function(){

		$(window).keypress(function(event) {
		    if (!(event.which == 115 && event.ctrlKey)) return true;
		    $('form').submit();
		    event.preventDefault();
		    return false;
		});

		$(document).keydown(function(e){
			var current = $('#content').data('current');
			var next = false;

			switch(e.which) {
				case(27):
					window.history.go(-1);
					e.preventDefault();
					break;
				case(38):
					next = current - 1;
					if(next<2)
						next = 1;
					break;
				case(40):
					next = current + 1;
					if(next>$('#content form input').length-1)
						next = $('#content form input').length-1;
					break;
				case(32):

					break;
				case(13):

					break;
			}
			if(next) {
				$('#content form input:eq('+next+')').select();
				$('#content').data('current', next);
			}
		});

		$('.photo-input>a').uploader({url:'/photo/upload'});
		$('.autocomplete').autocompleter();
	});
</script>
<div id="breadcrumbs">
	<?php if(isset($model) && $model): ?>
	<script>
	$(function(){
		$("#<?php echo $model ?>Title").syncTranslit({destination: "<?php echo $model ?>Slug"});
		$('.datetime').each(function(){
			label = $('label', this).html();
			name = $('select:first', this).attr('name');
			$(this).html(label + '<input name="'+name+'" class="datepicker">');
		});
		$('.datepicker').datepicker({dateFormat:"yy-mm-dd"});
		$('.input input:first').select();
	});
	</script>
	<h2><?php echo __('Edit', true).' '.__(Inflector::humanize($model), true); ?></h2>
	<?php $customize = false;?>
	<?php else: ?>
	<h2><?php echo __('Edit', true).' '.__(Inflector::humanize($module), true).' '.__('Options', true); ?></h2>
	<?php $model = $module;	$customize = true; endif; ?>
</div>

<?php echo $this->Form->create($model, array('url'=>'/'.$this->params['url']['url'])) ?>
<fieldset>
<?php
if ($multiple) {
	echo '<div class="multiple-list">';
	foreach($ids as $id) {
		echo $form->input($data[$id][$model]['title'], array('name'=>'id[]', 'value'=>$id, 'type'=>'checkbox', 'checked'=>'checked'));
	}
	echo '</div>';
} elseif(@$model && !$customize) {
	echo $form->input('id', array('type'=>'hidden'));
}

echo $this->Type->render($fields, $model, $multiple);

?>
</fieldset>
<div class="submit">
	<?php echo $html->link(__('Cancel', true), array('controller'=>'admin', 'action'=>'browse', 'model'=>$model, 'module'=>$module), array('class'=>'button cancel')) ?>
	<button type="submit" class="button save"><?php echo __('Save', true)?></button>
</div>
<?php $this->Form->end('') ?>