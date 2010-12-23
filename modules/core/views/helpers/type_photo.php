<?php 
class TypePhotoHelper extends AppHelper {
    var $helpers = array('Html', 'Form');
    
	function render($sender, $field, $model = '') {
        $this->output = '';

        $fieldName = Inflector::humanize($field);
        $image = '';
        
        if(!empty($this->data[$model][$field]))
            $image = $this->Html->image($this->data[$model][$field]);

        $this->output .= $this->Form->input($field, array('type'=>'hidden'));

        $this->output .=
        '<div class="photo-input"><label>'
        . $fieldName.'<a class="button delete" href="#" id="delete-'.$model.$fieldName.'">Remove</a>'
        .'</label><a id="'.$model.$fieldName.'-uploader" class="button file" href="#">'
        .$image
        .'Choose '.$field.'</a></div>';

        return $this->output;
    }
} 