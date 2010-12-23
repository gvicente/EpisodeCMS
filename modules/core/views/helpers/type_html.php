<?php 
class TypeHtmlHelper extends AppHelper {
    var $helpers = array('Form');
    
	function render($sender, $field, $model = '') {
        return $this->Form->input($field, array('class'=>'htmleditor'));
    }
} 