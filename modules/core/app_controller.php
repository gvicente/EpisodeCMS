<?php

include_once ('error.php');

class AppController extends Controller {

    var $theme = "default";
    var $layout = "page";
    var $helpers = array('Html', 'Form', 'Session', 'Javascript', 'Textile', 'Type', 'Filter', 'Theme');
    var $components = array('RequestHandler', 'Session', 'Event', 'Cookie');

    function __construct() {
        $this->view = 'Theme';
        parent::__construct();

        $menu = Configure::read('config.menus');
        $this->set(compact('menu'));

        $config = Configure::read('config');

        if (Configure::read('config.frontend.theme'))
            $this->theme = $config['frontend']['theme'];

        $this->set('site_theme', $this->theme);
        $this->set('widgets', '');

        $maintance = isset($config['modules']) && is_array($config['modules']['core']) && $config['modules']['core']['maintance'];
        if ($maintance && $this->name != 'Admin') {
            $this->cakeError('maintance');
        }

        if ($this->name != 'Install')
            $this->components[] = 'Auth';
    }

    function beforeRender() {
        if ($this->RequestHandler->isAjax()) {
            $this->view = 'Json';
        }

        if (isset($this->viewVars['title_for_layout']))
            $title = __($this->viewVars['title_for_layout'], true);
        else
            $title = $this->name;

        $config = Configure::read('config.modules.core');

        if (is_array($config['title'])) {
            $this->set('title_for_layout', $title . ' ' . $config['title']);
            $this->set('keywords', $config['keywords']);
            $this->set('description', $config['description']);
        }
    }

    function beforeFilter() {
        $theme = Configure::read('theme');
        $modules = Configure::read('modules');

        $menus = array();

        foreach ($modules as $config) {
            if (isset($config['menu'])) {
                $menus = array_extend($menus, $config['menu']);
            }
        }

        if(isset($theme['menu']))
            $menus = array_extend($menus, $theme['menu']);

        $this->set(compact('menus'));

        if ($this->name != 'Install') {
            $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
            $this->Auth->loginRedirect = array('controller' => 'admin', 'action' => 'index');
            $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
            $this->Auth->fields = array('username' => 'username', 'password' => 'password');

            if ($this->Auth->user() || ($this->name != 'Admin' && $this->name != 'Notifications')) {
                $this->Auth->allow('*');
            }

            $this->Auth->authorize = 'controller';
        }
    }

    function widget($id, $view, $data=array(), $class=false, $filter=false) {
        if ($this->checkAction($filter)) {
            if (!@$this->viewVars[$id])
                $this->set($id, '');

            @$this->viewVars[$id] .= $this->renderPartial($view, $data, $class);
        }
    }

    function renderPartial($view, $data=array(), $class=false) {
        if (!$class)
            $class = $this;

        App::import('View', $this->view);
        $viewClassName = $this->view . 'View';
        $View = new $viewClassName($this);
        $paths = $View->_paths(Inflector::underscore($class->plugin));
        foreach ($paths as $path) {
            if (file_exists($path . $class->viewPath . DS . $view . $class->ext)) {
                return $View->_render($path . $class->viewPath . DS . $view . $class->ext, $data);
            }
        }
    }

    // :TODO: Check it for ACL
    function requestAllowed($object, $property, $rules, $default = false) {
        // The default value to return if no rule matching $object/$property can be found
        $allowed = $default;

        // This Regex converts a string of rules like "objectA:actionA,objectB:actionB,..." into the array $matches.
        preg_match_all('/([^:,]+):([^,:]+)/is', $rules, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            list($rawMatch, $allowedObject, $allowedProperty) = $match;

            $allowedObject = str_replace('*', '.*', $allowedObject);
            $allowedProperty = str_replace('*', '.*', $allowedProperty);

            if (substr($allowedObject, 0, 1) == '!') {
                $allowedObject = substr($allowedObject, 1);
                $negativeCondition = true;
            }
            else
                $negativeCondition = false;

            if (preg_match('/^' . $allowedObject . '$/i', $object) &&
                    preg_match('/^' . $allowedProperty . '$/i', $property)) {
                if ($negativeCondition)
                    $allowed = false;
                else
                    $allowed = true;
            }
        }
        return $allowed;
    }

    function checkAction($actions) {
        if (!$actions)
            return true;
        foreach ($actions as $action) {
            list($controller, $action) = explode('/', $action);
            if (
                    (
                    $controller == '*'
                    ||
                    $this->name == $controller
                    )
                    &&
                    (
                    $action == '*'
                    ||
                    $this->action == $action
                    )
            )
                return true;
        }
        return false;
    }

}