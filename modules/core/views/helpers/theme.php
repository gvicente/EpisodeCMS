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
        foreach ($menu_items as $title => $item) {
            $text = '';

            if (isset($item['_image']))
                $text .= $this->image($item['_image']);

            if (!isset($item['_link']))
                $item['_link'] = '#';

            $title = explode('|', $title);

            $text .= $title[0];

            if (isset($title[1]))
                $text .= '<em>' . $title[1] . '</em>';

            $output .= '<li>';
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