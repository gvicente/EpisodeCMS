<?php 
class ThemeHelper extends AppHelper {
    var $helpers = array('Html');

    function image($url = null, $alt = null, $link = null) {
        $path = Configure::read('theme.path');
        $real_path = Configure::read('config.theme_path');
        if (file_exists($real_path.'/img/'.$url))
            return $this->Html->image($path.'/img/'.$url, array('alt'=>$alt, 'url'=>$link));
        else
            return '<span class="no-image">'.$url.'</span>';
    }

    function widget($widget_name, $view) {
        if (isset($view->viewVars[$widget_name]))
            $widgets = $view->viewVars[$widget_name];
        else
            $widgets = '';
        return '<div id="widet-'.$widget_name.'">'.$widgets.'</div>';
    }

    function menu($id = null) {
        $view =& ClassRegistry::getObject('view');
        $output = '';

        if (isset($view->viewVars['menus'][$id])) {
            $menu_items = $view->viewVars['menus'][$id];
            unset($menu_items['_title']);
            
            $output = $this->render_menu($menu_items);
        }
        
        return $output;
    }

    function render_menu($menu_items = array()) {
        $output = '';
        if(is_array($menu_items))
        foreach ($menu_items as $title => $item)
        if(is_array($item)) {
            $text = '';
            $class = 'item';

            if (isset($item['_image'])) {
                $text .= $this->image($item['_image']);
                $class .= ' image';
            }

            if (!isset($item['_link']))
                $item['_link'] = '#';

            $title = explode('|', $title);

            $text .= '<span>'.__($title[0], true).'</span>';

            if (isset($title[1]))
                $text .= '<em>' . __($title[1], true) . '</em>';

            $output .= "<li class='$class'>";
            $output .= $this->Html->link(__($text, true), $item['_link'], array('escape' => false));

            unset($item['_image']);
            unset($item['_link']);
            
            if (sizeof($item)>0)
                $output .= '<ul>'.$this->render_menu($item).'</ul>';

            $output .= '</li>';
        }
        return $output;
    }
} 