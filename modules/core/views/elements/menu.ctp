<?php
	// :TODO: Move to helper Navigation (or nav or menu)
	if(!function_exists('get_childs')) {
		function get_childs($items = false, $_this) {
			if(is_array(@$items['@link']))
				unset($items['@link']);
			if($items && is_array($items)) {
				$hasActive = false;
				$result = '<ul>';
				foreach($items as $title=>$item) {
					$childs = get_childs(@$item, $_this);
					// :TODO: Check if it's active
					$isActive = Router::url(@$item['@link']) == $_this->here;
					$hasActive = @$isActive || @$childs['hasActive']; 
					if($title!='@link') {
						$result.= '<li>';
						
			 			unset($subtitle);
						
						if(strpos($title, '|')!==false) {
							list($title, $subtitle) = explode('|', $title);
						}
						
						$result.= '<a href="'.Router::url(@$item['@link']).'">'.__($title, true);
						
						if(!empty($subtitle))
							$result.= '<em>'.__($subtitle, true).'</em>';
							
						$result.= '</a>';  
		
						$result.= @$childs['html'].'</li>';
					}
				}
					
				$result.= '</ul>';
				return array('html'=>$result, 'hasActive'=>$hasActive);
			} else return array('html'=>'', 'hasActive'=>false);
		}
	}
?>
<?php 
// :TODO: Remove it. Use only function.
if(isset($id) && is_array(@$menu[$id]))
	$menu = $menu[$id];
elseif(!isset($id) && is_array(@$menu['main']))
	$menu = $menu['main'];
		
if(isset($menu))
foreach($menu as $title=>$item) { 
	$childs = get_childs(@$item, $this);
	unset($subtitle);
	$item['active']	= $this->here == Router::url(@$item['@link']);
	?>
	<li<?php echo @$item['active']?' class="active"':''?>>
		<?php 
			if(strpos($title, '|')!==false) {
				list($title, $subtitle) = explode('|', $title);
			}
			echo '<a href="'.Router::url(@$item['@link']).'">'.__($title, true);
			if(!empty($subtitle))
				echo '<em>'.__($subtitle, true).'</em>';
			echo '</a>';  
		?>
		<?php echo @$childs['html'] ?>
	</li>
<?php } ?>
