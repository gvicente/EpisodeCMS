<?php 
class FilterHelper extends AppHelper { 
    function add($name, $value) {
    	$this->output = $this->here.'?';
    	$filters = isset($_GET['filter'])?$_GET['filter']:array();
    	
    	if (isset($filters[$name]) && $filters[$name] == $value) {
    		unset($filters[$name]);
    	} else {
    		$filters[$name] = $value;	
    	}
    	
    	$i = 0;
    	foreach($filters as $filterName=>$filterValue) {
    		if($i++>0)
    			$this->output.='&';
    		$this->output.='filter['.$filterName.']='.$filterValue;
    	} 
    	return $this->output;
    }
    
    function link($title, $name, $value) {
    	$class = '';
    	if (isset($_GET['filter']) && isset($_GET['filter'][$name]) && $_GET['filter'][$name] == $value)
    		$class = 'class="selected"'; 
    	return '<a '.$class.' href='.$this->add($name, $value).'>'.$title.'</a>';
    }
} 
?>