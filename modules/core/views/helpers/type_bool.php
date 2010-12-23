<?php 
class TypeBoolHelper extends AppHelper {
    var $helpers = array('Form');
    
	function render($sender, $field, $model = '') {
        return $this->Form->input($field, array('type'=>'checkbox'));
    }
} 