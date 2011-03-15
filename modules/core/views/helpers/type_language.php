<?php 
class TypeLanguageHelper extends AppHelper {
    var $helpers = array('Html', 'Form');
    
	function render($sender, $field, $model = '') {
        $this->output = '';

        $fieldName = Inflector::humanize($field);

        $view =& ClassRegistry::getObject('view');

        $widget =
            '<h2>'
            . $fieldName
            .'</h2>'
            .'<div class="content select">'
            .'<ul>'
            .'<li class="filter-active"><a href="#">ru</a></li>'
            .'<li><a href="#">en</a></li>'
            .'</ul>'
            .'</div>';



        $sender->addWidget($widget, 'switch-input');

        return $this->output;
    }
} 