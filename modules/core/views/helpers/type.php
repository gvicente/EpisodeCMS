<?php

class TypeHelper extends AppHelper {
    var $widgets = '';
    
    function  __construct() {
        parent::__construct();

        $Folder = & new Folder();
        $helpers = array();

        foreach(App::getInstance()->helpers as $path) {
            $Folder->cd($path);
            $helpers = array_extend(array_map('__helperize', $Folder->find('type_.+\.php$')), $helpers);
        }

        $this->helpers = $helpers;
    }

    function get($name) {
        $helper = 'Type'.ucwords($name);
        if(isset($this->{$helper}) && method_exists($this->{$helper}, 'render'))
            return $this->{$helper};
        else
            return $this->TypeString;
    }

    function render($config = array(), $model = null, $multiple = false) {
        $this->output = '';

        $fields = $config[$model];
        
        foreach ($fields as $field => $type) {
            if ($field[0] != '_' && $field[0] != '#') {
                $required = $type;
                $type = str_replace('*', '', $type);
                $required = $type != $required;

                $hidden = $type;
                $type = str_replace('#', '', $type);
                $hidden = ($type != $hidden);

                $fieldName = Inflector::humanize($field);

                if (!$hidden) {
                    $this->output .= $this->get($type)->render(&$this, $field, $model);
                }
            } elseif($field == '_relations') {
                foreach($type as $relation)
                if (is_array($relation)) {
//                    $title = $relation['title'];
//                    $list = $relation['name'];
//                    $view = @$relation['view'];
//                    $type = @$relation['type'];
//
//                    if($view == 'tree') {
//                        if(sizeof($$list)>0) {
//                            $content = '<ul>';
//                            foreach($$list as $listId=>$listTitle) {
//                                $content .= '<li><input id="'.$listId.'" type=checkbox>'.$listTitle.'</li>';
//                            }
//                            $content .= '</ul>';
//                        } else {
//                            $content = '<p>No categories</p>';
//                        }
//
//                        @$this->viewVars['widgets'] .=
//                        '<div class="widget">'
//                        .'<h2>'
//                        .__($title, true)
//                        .'</h2>'
//                        .'<div class="content">'
//                        .$content
//                        .'</div>'
//                        .'</div>';
//                    } elseif(strpos($view, 'autocomplete')!==false) {
//                        echo $form->input($title, array('type'=>'hidden', 'id'=>$title));
//                        $content = '<div class="autocomplete" id="'.$title.'-autocomplete"><input><ul id="'.$title.'-autocomplete-list" style="display:none">';
//                        foreach($$list as $listId=>$listTitle) {
//                            $content .= '<li><a slug="'.$listId.'" href="#">'.$listTitle.'</a></li>';
//                        }
//                        $content .= '</ul><ul class="tags-list" id="'.$title.'-list"></ul></div>';
//
//                        @$this->viewVars['widgets'] .=
//                        '<div class="widget">'
//                        .'<h2>'
//                        .__($title, true)
//                        .'</h2>'
//                        .'<div class="content">'
//                        .$content
//                        .'</div>'
//                        .'</div>';
//                    }
                }
            }
        }
        
        return $this->output;
    }

    function addWidget($html = '', $name = null) {
        $this->widgets .= '<div class="widget '. $name .'">' . $html . '</div>';
    }

    function widgets() {
        return $this->widgets;
    }
}
?>