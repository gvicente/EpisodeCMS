<script>
(function($) {
	$.fn.autocompleter = function(options) {
		var defaults = {

	    };

	    var opts = $.extend(defaults, options);

	    return this.each(function(e, obj){

		    var id = obj.id;
			var $obj = $(obj);
			var $this = $('#'+id+' input');
			var $result = $('#'+id.replace('-autocomplete','')+'-list');
			var $input = $('#'+id.replace('-autocomplete',''));
			var $list = $('#'+id+'-list');
			var width = $this.width();

			if ($input.val()) {
				slugs = $input.val().split(',');
				text = '';
				$.each(slugs, function(i, slug){
					var $finded = $('a[slug='+slug+']', $list);
					title = $finded.text();
					$finded.remove();
					if(!title)
						title = slug;
					$result.append('<li>'+title+'<a slug="'+slug+'" class="'+id+' delete" href="#">x</a></li>');
				});
			}

			$this.after('<a id="'+id+'-add" class="add" href="#">»</a>');

			var $addButton = $('#'+id+'-add');

			function add(text, slug) {
				if(!slug)
					slug = text;
				$result.append('<li>'+text+'<a slug="'+slug+'" class="'+id+' delete" href="#">x</a></li>');
				$this.val('');

				var ids = $input.val();
				if(ids!='')
					ids += ',';
				$input.val(ids + slug);
			}

			$addButton.css({'margin-left':-23});

			$addButton.click(function(){
				add($this.val());
			})

			$list.css({position:'absolute',background:'#fff',padding:'5px','list-style':'none','margin-top':-1,width:width-10});
			$('#'+id+'-list li a').css({outline:'none'});
			$this.quicksearch('#'+id+'-list li');

			$this.keydown(function(e){
				$list.show();
				if(e.keyCode == 13) {
					add($this.val());
				}
			});

			$('#'+id+'-list li a').live('click', function(){
				add($(this).text(), $(this).attr('slug'));
				$(this).parent().remove();
				$list.hide();
				return false;
			});

			$('.'+id+'.delete').live('click', function(){
				var $parent = $(this).parent();
				$(this).remove();
				slug = $(this).attr('slug');
				$list.append('<li><a slug="'+slug+'" href="#">'+$parent.text()+'</a></li>');
				$parent.remove();
				$this.quicksearch('#'+id+'-list li');

				var ids = '';
				$('li a', $result).each(function(i, obj){
					slug = $(obj).attr('slug');
					if(ids!='')
						ids += ',';
					ids += slug;
				});
				$input.val(ids);
				return false;
			});

			$obj.hover(function(){

			}, function(){
				$list.hide();
			})
		})
	}
})(jQuery);

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
	<?php else: ?>
	<h2><?php echo __('Edit', true).' '.__(Inflector::humanize($module), true).' '.__('Options', true); ?></h2>
	<?php $model = $module;	endif; ?>
</div>

<?php echo $form->create($model, array('url'=>'/'.$this->params['url']['url'])) ?>
<fieldset>
<?php
if(@$multiple) {
	echo '<div class="multiple-list">';
	foreach($ids as $id) {
		echo $form->input($data[$id][$model]['title'], array('name'=>'id[]', 'value'=>$id, 'type'=>'checkbox', 'checked'=>'checked'));
	}
	echo '</div>';
} elseif(@$model) {
	echo $form->input('id', array('type'=>'hidden'));
}

echo $type->renderFields($fields[$model]);
if(@$fields[$model]):
foreach($fields[$model] as $name => $params) {
	if($name[0] != '@' && $params[0] != '#') {
		if(!@$multiple || ($multiple && $params[strlen($params)-1] != '*')) {
			if(strpos($params, 'thumb')!==false) {
				$fieldName = Inflector::humanize($name);
				$image = '';
				if(!empty($this->data[$model][$name]))
					$image = $html->image($this->data[$model][$name]);
				echo $form->input($name, array('type'=>'hidden'));
				@$this->viewVars['widgets'] .=
				'<div class="widget photo-input"><h2>'
				. $fieldName.'<a class="button" href="#" id="delete-'.$model.$fieldName.'">Remove</a>'
				.'</h2><a id="'.$model.$fieldName.'-uploader" class="button" href="#">'
				.$image
				.'Choose '.$name.'</a></div>';
			} elseif(strpos($params, 'photo')!==false) {
				$fieldName = Inflector::humanize($name);
				$image = '';
				if(!empty($this->data[$model][$name]))
					$image = $html->image($this->data[$model][$name]);
				echo $form->input($name, array('type'=>'hidden'));
				echo
				'<div class="photo-input"><label>'
				. $fieldName.'<a class="button delete" href="#" id="delete-'.$model.$fieldName.'">Remove</a>'
				.'</label><a id="'.$model.$fieldName.'-uploader" class="button file" href="#">'
				.$image
				.'Choose '.$name.'</a></div>';
			} elseif(strpos($params, 'html')!==false) {
				echo $form->input($name, array('class'=>'htmleditor'));
			} elseif(strpos($params, 'text')!==false) {
				echo $form->input($name, array('type'=>'textarea'));
			} elseif(strpos($params, 'bool')!==false) {
				echo $form->input($name, array('type'=>'checkbox'));
			} elseif(strpos($params, 'password')!==false) {
				echo $form->input($name, array('type'=>'password', 'value'=>'', 'label'=>'New '.$name));
			} else
				echo $form->input($name, array('autocomplete'=>'off'));
		}
	} elseif($name == '@relations') {

		foreach($params as $relation) {
			$title = $relation['title'];
			$list = $relation['name'];
			$view = @$relation['view'];
			$type = @$relation['type'];

			if($view == 'tree') {
				if(sizeof($$list)>0) {
					$content = '<ul>';
					foreach($$list as $listId=>$listTitle) {
						$content .= '<li><input id="'.$listId.'" type=checkbox>'.$listTitle.'</li>';
					}
					$content .= '</ul>';
				} else {
					$content = '<p>No categories</p>';
				}

				@$this->viewVars['widgets'] .=
				'<div class="widget">'
				.'<h2>'
				.__($title, true)
				.'</h2>'
				.'<div class="content">'
				.$content
				.'</div>'
				.'</div>';
			} elseif(strpos($view, 'autocomplete')!==false) {
				echo $form->input($title, array('type'=>'hidden', 'id'=>$title));
				$content = '<div class="autocomplete" id="'.$title.'-autocomplete"><input><ul id="'.$title.'-autocomplete-list" style="display:none">';
				foreach($$list as $listId=>$listTitle) {
					$content .= '<li><a slug="'.$listId.'" href="#">'.$listTitle.'</a></li>';
				}
				$content .= '</ul><ul class="tags-list" id="'.$title.'-list"></ul></div>';

				@$this->viewVars['widgets'] .=
				'<div class="widget">'
				.'<h2>'
				.__($title, true)
				.'</h2>'
				.'<div class="content">'
				.$content
				.'</div>'
				.'</div>';
			}
		}
	}
}
else:
?>
<p>There is no options to edit</p>
<?php
endif;
?>
</fieldset>
<div class="submit">
	<?php echo $html->link(__('Cancel', true), array('controller'=>'admin', 'action'=>'browse', 'model'=>$model, 'module'=>$module), array('class'=>'button cancel')) ?>
	<button type="submit" class="button save"><?php echo __('Save', true)?></button>
</div>
</form>