<?php 
class TypeStringHelper extends AppHelper {
    var $helpers = array('Form');
    
	function render($sender, $field, $model = '') {
        return $this->Form->input($field, array('autocomplete'=>'off'));
    }
} 