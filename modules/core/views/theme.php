<?php

class ThemeView extends View {

    var $themeElement = null;
    var $themeLayout = null;
    var $themePath = null;

    function __construct(&$controller, $register = true) {
        parent::__construct($controller, $register);
        $this->theme = & $controller->theme;
    }

    function _getLayoutFileName($name = null) {
        if ($name === null) {
            $name = $this->layout;
        }
        $subDir = null;

        if (!is_null($this->layoutPath)) {
            $subDir = $this->layoutPath . DS;
        }

        $paths = $this->_paths(Inflector::underscore($this->plugin));
        $file = $subDir . $name;

        $exts = array($this->ext, '.ctp', '.html');
        foreach ($exts as $ext) {
            foreach ($paths as $path) {
                if (file_exists($path . $file . $ext)) {
                    return $path . $file . $ext;
                }
            }
        }
        return $this->_missingView($paths[0] . $file . $this->ext, 'missingLayout');
    }

    function _paths($plugin = null, $cached = true) {
        $paths = parent::_paths($plugin, $cached);
        $modules = Configure::read('modules');
        if (!empty($this->theme)) {

            foreach ($modules as $module => $config) {
                $paths = array_merge(
                                array(ROOT . DS . 'modules' . DS . $module . DS . 'themes' . DS . $this->theme . DS),
                                $paths
                );
            }

            $paths = array_merge(array(ROOT . DS . 'themes' . DS . $this->theme . DS), $paths);
        }

        if (empty($this->__paths)) {
            $this->__paths = $paths;
        }
        return $paths;
    }

    function renderLayout($content_for_layout, $layout = null) {
        if (isset($this->viewVars['title_for_layout'])) {
            $pageTitle = $this->viewVars['title_for_layout'];
        } else {
            $pageTitle = Inflector::humanize($this->viewPath);
        }

        $scripts = array();
        $styles = array();
        $modules = Configure::read('modules');
        
        foreach ($modules as $module => $config) {
            if (isset($config['scripts']))
                $scripts = array_merge($scripts, $config['scripts']);

            if (isset($config['styles']))
                $styles = array_merge($styles, $config['styles']);

            if (file_exists(ROOT . DS . 'modules' . DS . $module . DS . 'themes' . DS . $this->theme . DS . 'style.css'))
                $styles[] = '/modules/' . $module . '/themes/' . $this->theme . '/style';
        }

//        if (file_exists(ROOT . DS . 'modules' . DS . $module . DS . 'themes' . DS . 'default' . DS . 'style.css'))
//            $styles[] = '/modules/' . $module . '/themes/default/style';

        if (file_exists(ROOT . DS . 'themes' . DS . $this->theme . DS . 'style.css'))
            $styles[] = '/themes/' . $this->theme . '/style';

        $content_for_layout = @$this->viewVars['top'] . @$content_for_layout . @$this->viewVars['bottom'];
        unset($this->viewVars['top']);
        unset($this->viewVars['bottom']);

        $this->viewVars = array_merge($this->viewVars, array(
                    'headers' => $this->element('headers', array(
                        'title_for_layout' => $pageTitle,
                        'scripts' => $scripts,
                        'styles' => $styles
                    ))
                ));
        return parent::renderLayout($content_for_layout, $layout = null);
    }

}

?>