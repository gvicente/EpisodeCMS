<?php 
class TypeHelper extends AppHelper { 
    function renderFields($fields = array()) {
    	
    	$this->output = '';
    	
    	foreach($fields as $field=>$type) {
    		if($field[0] != '@' && $field[0] != '#') {
	    		$required = $type;
	    		$type = str_replace('*', '', $type);
	    		$required = $type!=$required;
	    		
	    		$hidden = $type;
	    		$type = str_replace('#', '', $type);
	    		$hidden = ($type != $hidden);
	    		
	    		if(!$hidden) {
	    			$helperClass = 'TypeString';
	    			App::import('Helper', $helperClass);
	    			$helperClass.='Helper';
	    			$string = & ClassRegistry::init($helperClass, 'helper');
	    			$helper = $string; 
	    			
	    			$helperClass = 'Type'.Inflector::classify($type);
	    			if(App::import('Helper', $helperClass)) {
	    				$helperClass.='Helper';
	    				$helper = & ClassRegistry::init($helperClass, 'helper');
	    				if(!method_exists($helper, 'render')) {
	    					$helper = $string; 	
	    				}
	    			}
	    			
	    			$this->output .= $helper->render($field);
	    		}
    		}
    	}
    	return $this->output;
    }
} 
?>