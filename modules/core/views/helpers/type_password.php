<?php
class TypePasswordHelper extends AppHelper {
    var $helpers = array('Form');

	function render($sender, $field, $model = '') {
        return $this->Form->input($field, array('type'=>'password', 'value'=>'', 'label'=>'New '.$field));
    }
}