<?php 
class ThemeHelper extends AppHelper {
    var $helpers = array('Html', 'Type');

    function breadcrumbs($devider = false, $id = "main") {
        $breadcrumbs = Configure::read('breadcrumbs');
        $result = '';
        if ($breadcrumbs) {
            if (!$devider)
                $devider = ' ';
            $crumbs = array();
            foreach ($breadcrumbs as $breadcrumb) {
                $crumbs[] = '<a href="'.$breadcrumb['link'].'">'.$breadcrumb['text'].'</a>';
            }
            $result .= '<div id="breadcrumbs-'.$id.'">'.join($devider, $crumbs).'</div>';
        }
        return $result;
    }

    function image($url = null, $alt = null, $link = null) {
        $path = Configure::read('theme.path');
        $real_path = Configure::read('config.theme_path');
        if (file_exists($real_path.'/img/'.$url))
            return $this->Html->image($path.'/img/'.$url, array('alt'=>$alt, 'url'=>$link));
        else
            return '<span class="no-image">'.$url.'</span>';
    }

    function wrapper($widget_name, $view, $id = '') {
        if (isset($view->viewVars[$widget_name]))
            $widgets = $view->viewVars[$widget_name];
        else
            $widgets = '';
        
        if ($widget_name == 'widgets')
            $widgets .= $this->Type->widgets();

        $widget_id = $id;
        if (!$widget_id)
           $widget_id =  'widget-'.$widget_name;
        
        return '<div id="'.$widget_id.'">'.$widgets.'</div>';
    }

    function menu($id = null, $params = array()) {
        $menu_items = Configure::read('menus.'.$id);
        $output = '';

        if ($menu_items) {
            unset($menu_items['_title']);
            $output = $this->render_menu($menu_items, $params);
        }
        
        return $output;
    }

    function render_menu($menu_items = array(), $params = array()) {
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
            $output .= $this->Html->link(__($text, true), $item['_link'], array_extend(array('escape' => false), $params));

            unset($item['_image']);
            unset($item['_link']);
            
            if (sizeof($item)>0)
                $output .= '<ul>'.$this->render_menu($item).'</ul>';

            $output .= '</li>';
        }
        return $output;
    }

    function widget($name, $params=array()) {
        $app = new AppController();
        $app->constructClasses();

        $widget_name = 'Widget'.Inflector::classify(str_replace('/', '_', $name));
        if ($data = $app->Event->triggerEvent($widget_name, $params))
            $data = end($data['Global'][$widget_name]);

        return $app->renderPartial('../'.$name, compact('data'));
    }

    function block($slug) {
        $widget = new WidgetsController();
        return $widget->_showBlock($slug);
    }
} 