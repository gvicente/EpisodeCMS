<?php

include_once ('error.php');

class AppController extends Controller {

    var $theme  = "default";
    var $layout = "page";
    var $ui     = "main";

    function __construct() {
        $this->components = array('RequestHandler', 'Session', 'Event', 'Cookie');
        $this->helpers = array('Html', 'Form', 'Session', 'Javascript', 'Textile', 'Type', 'Filter', 'Theme');
        
        $this->view = 'Theme';
        parent::__construct();

        $config = Configure::read('config');
        
        $ui = Configure::read('ui');
        
        $maintance = isset($ui[$this->ui]['_maintance']) && $ui[$this->ui]['_maintance'];
        if ($maintance && $this->ui == 'main') {
            $this->cakeError('maintance');
        }

        if ($this->name != 'Install')
            $this->components[] = 'Auth';
        
        $this->module = $this->viewPath;
        $this->breadcrumbs = array();
    }

    function beforeFilter() {
        $this->addBreadcrumb(__('Content', true), '/admin/overview', 'root');
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
        $language = $this->Cookie->read('language');
        Configure::write('Config.language', $language);
        $this->Event->triggerEvent('Startup' . Inflector::humanize($this->ui));
        Configure::write(compact('menus'));
    }

    function beforeRender() {
        Configure::write('breadcrumbs', $this->breadcrumbs);
        $config = Configure::read('config');
        if ($this->RequestHandler->isAjax()) {
            $this->view = 'Json';
        }

        if (isset($this->viewVars['title_for_layout']))
            $title = __($this->viewVars['title_for_layout'], true);
        else
            $title = $this->name;

        $ui_title = Configure::read('ui.'.$this->ui.'._title');
        $keywords = Configure::read('ui.'.$this->ui.'._keywords');
        $description = Configure::read('ui.'.$this->ui.'._description');
        $ui_title_template = Configure::read('ui.'.$this->ui.'._title_template');
        if(!$ui_title_template) {
            $ui_title_template = ':page | :ui';
        }

        $title_for_layout = String::insert($ui_title_template, array('ui'=>$ui_title, 'page'=>$title));

        if (!$config['setup'])
            $user = $this->Auth->user();

        $this->set(compact('title_for_layout', 'keywords', 'description', 'user'));

        $layout  = Configure::read('ui.'.$this->ui);
        $this->theme = $layout['_theme'];

        unset($layout['_title']);
        unset($layout['_theme']);

        foreach ($layout as $bar => $widgets_array) {
            if ($bar[0] != '_') {
                foreach ($widgets_array as $widget => $param) {
                    $this->widget($bar, '../'.$widget, array(), false, $param['_allow']);
                }
            }
        }

        $this->Event->triggerEvent('Render' . Inflector::humanize($this->ui));
    }

    function request($request_string, $redirect = false) {
        if (!empty($this->data)) {
            list($model, $action) = explode('/', $request_string);
            App::import('Controller', 'Admin');
            $admin_controller = new AdminController();
            $admin_controller->constructClasses();
            $admin_controller->data = $this->data;
            @$admin_controller->$action($this->module, $model, $this->data[$model]['id'], false);
            $this->redirect($redirect);
        }
    }

    function addBreadcrumb($text, $link, $id=false) {
        if (!$id)
            $id = sizeof($this->breadcrumbs);
        $this->breadcrumbs[$id] = compact('link', 'text');
        return $id;
    }

    function removeBreadcrumb($id) {
        unset($this->breadcrumbs[$id]);
    }

    function loadHelper($helper_name) {
        $this->helpers = array_extend($this->helpers, array($helper_name));
    }

    function widget($id, $view, $data=array(), $controller=false, $filter=false) {
        $allowed = $this->checkAction($filter);
        if ($allowed) {
            $content = '';
            if (isset($this->viewVars[$id]))
                $content = $this->viewVars[$id];
            
            $this->set($id, $content.$this->renderPartial($view, $data, $controller));
        }
    }

    function renderPartial($view, $data=array(), $class=false) {
        if (!$class)
            $class = $this;

        App::import('View', $this->view);
        $viewClassName = $this->view . 'View';
        $View = new $viewClassName($this);
        $paths = $View->_paths(Inflector::underscore($class->plugin));
        
        $view_path = $class->viewPath;
        if ($view[0] == '.') {
            $view = str_replace('../', '', $view);
            $view_path = '';
        }

        foreach ($paths as $path) {
            $full_path = $path . $view_path . DS . $view . $class->ext;
            if (file_exists($full_path)) {
                return $View->_render($full_path, $data);
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

    // @todo: Add check on all $actions
    function checkAction($actions) {
        $result = false;

        if (!$actions || $actions == '*')
            $result = true;
        
        if (!is_array($actions))
            $actions = array(0 => $actions);

        foreach ($actions as $action) {
            if (strstr('/', $action))
                list($controller, $action) = explode('/', $action);
            else
                $controller = '*';
        
            if (($controller == '*' || $this->name == $controller)
            && ($action == '*'||$this->action == $action))
                $result = true;
        }
        
        return $result;
    }

}