<script>
	$(function(){
		$('#checkall').click(function(e){
			$('#content table td.first input').turn($(this).attr('checked'));
		});
		$('#content table tr td:not(.first)').click(function(){
			$('td.first input', $(this).parent()).turn();
		});
		
		$.fn.turn = (function(status){
			if(status==null)
				status=!this.attr('checked');
			this.attr('checked', status);
			this.change();
		})
		
		$('#content table td.first input').change(function(){
			if($(this).attr('checked'))
				$(this).parent().parent().addClass('ui-selected');
			else
				$(this).parent().parent().removeClass('ui-selected');
				
			if ($('#content table td.first input:checked').length > 0) 
				$('#content table tfoot').show();
			else 
				$('#content table tfoot').hide();
			 
			$('#checkall').attr('checked', $('#content table td.first input:checked').length == $('#content table td.first input').length);
		});
		
		$('#content table .first input').turn(false);
		$('#content table tfoot').hide();
		
		$('.multiple').click(function(){
			href = $(this).attr('href');
			ids = '';
			
			$('#content table td.first input:checked').each(function(){
				if(ids)
					ids += ',' + $(this).attr('num');
				else
					ids = $(this).attr('num');
			});
			
			href = href.replace('%', ids);
			window.location.href = href; 
			return false;
		});
		
		$(document).keydown(function(e){
			var current = $('#content').data('current');
			var next = false; 
			
			switch(e.keyCode) {
				case(192):
					window.location.href = $.url('/admin/overview');
					break;
				case(38):
					next = current - 1;
					if(next<2)
						next = 1; 
					break;
				case(40):
					next = current + 1;
					if(next>$('#content table tr').length-1)
						next = $('#content table tr').length-1;
					break;
				case(32):
					$('#content table tr:eq('+current+') input').turn();
					break;
				case(13):
					if(current) {
						$('#content table tr:eq('+current+') input').turn(true);
						$('#edit').click();
					}
					break;
			}
			if(next) {
				$('#content table tr:eq('+current+')').removeClass('active');
				$('#content table tr:eq('+next+')').addClass('active');
				$('#content').data('current', next);
			}
		});
	});
</script>
<h2>Browse <?php echo Inflector::pluralize($model) ?> <?php if(!$static) echo $html->link('Add', array('controller'=>'admin', 'action'=>'edit', 'model'=>$model, 'module'=>$module), array('class'=>'button')) ?></h2>
<table cellspacing="0">
	<thead>
	<tr>
	<th class="first"><input id="checkall" type="checkbox"></th>
	<th><?php __('Title') ?></th>				
	<?php foreach($columns as $column): ?>
		<th class="last"><?php echo __($column, true)?></th>
	<?php endforeach; ?>
	</tr>
	</thead>
	<tfoot>
		<td colspan="<?php echo sizeof($columns)+2 ?>">
			<?php __('Selected elements:') ?>
			<?php echo $html->link('Edit', array('action'=>'edit', 'module'=>$module, 'model'=>$model, 'id'=>'%'), array('class'=>'button multiple', 'id'=>'edit'))?>
			<?php echo $html->link('Delete', array('action'=>'delete', 'module'=>$module, 'model'=>$model, 'id'=>'%'), array('class'=>'button multiple', 'id'=>'delete'))?>
		</td>
	</tfoot>
	<tbody>
<?php if(@$data): ?>
<?php foreach($data as $key=>$entry): ?>
	<tr class="<?php echo ($key % 2==0)?"even":"odd" ?>">
		<td class="first"><input type="checkbox" num="<?php echo @$entry[$model]['id'] ?>"></td>
		<td class="title">
			<?php
				preg_match_all('!((<[^>]+>)?([^<]+)(</[^>]+>)?)+!', @$entry[$model][$maincolumn], $matches);
				$content = join(' ',$matches[3]);
			?>
			<strong><?php echo $html->link(@$content, array('action'=>'edit', 'module'=>$module, 'model'=>$model, 'id'=>@$entry[$model]['id']))?></strong>
		</td>
		<?php foreach($columns as $column=>$title): ?>
		<td class="last">
			<?php echo $textile->process(@$entry[$model][$column]);?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
<?php else:  ?>
	<tr>
		<td colspan="2" class="title">
			No <?php echo Inflector::pluralize($model) ?>
			<?php if(!$static) echo $html->link('Add new', array('controller'=>'admin', 'action'=>'edit', 'model'=>$model, 'module'=>$module), array('class'=>'button')).'?' ?>
		</td>
	</tr>
<?php endif; ?>
	</tbody>
</table>