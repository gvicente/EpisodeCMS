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
<h2><?php echo String::insert(__(':genitive '.Inflector::pluralize($model), true), array('genitive'=>__('Browse', true))) ?> <?php if(!$static) echo $html->link(__('Add', true), array('controller'=>'admin', 'action'=>'edit', 'model'=>$model, 'module'=>$module), array('class'=>'button add')) ?></h2>
<table cellspacing="0">
	<thead>
	<tr>
	<th class="first"><input id="checkall" type="checkbox"></th>
    <?php if(!isset($columns['title'])): ?>
	<th><?php __('Title') ?></th>
    <?php endif ?>
	<?php foreach($columns as $column): ?>
		<th class="last"><?php echo __($column, true)?></th>
	<?php endforeach; ?>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<td colspan="<?php echo sizeof($columns)+2 ?>">
			<?php __('Selected elements:') ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', 'module'=>$module, 'model'=>$model, 'id'=>'%'), array('class'=>'button edit multiple', 'id'=>'edit'))?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', 'module'=>$module, 'model'=>$model, 'id'=>'%'), array('class'=>'button delete multiple', 'id'=>'delete'))?>
		</td>
	</tr>
	</tfoot>
	<tbody>
<?php if(@$data): ?>
<?php foreach($data as $key=>$entry): ?>
	<tr class="<?php echo ($key % 2==0)?"even":"odd" ?>">
		<td class="first"><input type="checkbox" num="<?php echo @$entry[$model]['id'] ?>"></td>
        <?php if(!isset($columns['title'])): ?>
		<td class="title">
			<?php
				preg_match_all('!((<[^>]+>)?([^<]+)(</[^>]+>)?)+!', @$entry[$model][$maincolumn], $matches);
				$content = join(' ',$matches[3]);
			?>
			<strong><?php echo $html->link(@$content, array('action'=>'edit', 'module'=>$module, 'model'=>$model, 'id'=>@$entry[$model]['id']))?></strong>
		</td>
        <?php endif ?>
		<?php foreach($columns as $column=>$title): ?>
		<td class="last">
			<?php echo $textile->process(@$entry[$model][$column]);?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
<?php else:  ?>
<?php
    $colspan = sizeof($columns) + 1;
    if (!isset($columns['title']))
        $colspan++;
?>
	<tr>
		<td colspan="<?php echo $colspan ?>" class="title">
			<?php echo String::insert(__(':genitive '.Inflector::pluralize($model), true), array('genitive'=>__('No', true))) ?>
		</td>
	</tr>
<?php endif; ?>
	</tbody>
</table>