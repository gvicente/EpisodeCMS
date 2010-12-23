<?php 
class TypeThumbHelper extends AppHelper {
    var $helpers = array('Html', 'Form');
    
	function render($sender, $field, $model = '') {
        $this->output = '';
        
        $fieldName = Inflector::humanize($field);

        $image = '';

        if(!empty($this->data[$model][$field]))
            $image = $this->Html->image($this->data[$model][$field]);

        $this->output .= $this->Form->input($field, array('type'=>'hidden'));

        $view =& ClassRegistry::getObject('view');

        $widget =
            '<h2>'
            . $fieldName.'<a class="button" href="#" id="delete-'.$model.$fieldName.'">Remove</a>'
            .'</h2><a id="'.$model.$fieldName.'-uploader" class="button" href="#">'
            .$image
            .'Choose '.$field.'</a>';



        $sender->addWidget($widget, 'photo-input');

        return $this->output;
    }
} 