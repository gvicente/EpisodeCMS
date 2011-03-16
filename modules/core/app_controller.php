<?php

include_once ('error.php');

class AppController extends Controller {

    var $theme  = "default";
    var $layout = "default";
    var $ui     = "main";

    function __construct() {
        $info = new ReflectionClass($this);
        $this->module = basename(dirname($info->getFileName()));
        $this->module = 'blog';

        $this->components = array('RequestHandler', 'Session', 'Event', 'Cookie');
        $this->helpers = array('Html', 'Form', 'Session', 'Javascript', 'Textile', 'Type', 'Filter', 'Theme');
        App::import('Core', 'l10n');
        $this->L10n = new L10n();

        $this->view = 'Theme';
        parent::__construct();
        
        $ui = Configure::read('ui');
        
        $maintance = isset($ui[$this->ui]['_maintance']) && $ui[$this->ui]['_maintance'];
        if ($maintance && $this->ui == 'main') {
            $this->cakeError('maintance');
        }

        if ($this->name != 'Install')
            $this->components[] = 'Auth';
        
        $this->breadcrumbs = array();
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
        if ($language)
            Configure::write('Config.language', $language);
        $language = $this->L10n->map($language);
        Configure::write(compact('language'));
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
        if (isset($layout['_theme']))
            $this->theme = $layout['_theme'];
        elseif (isset($layout['_ui'])) {
            $layout_support = Configure::read('ui.'.$layout['_ui']);
            $this->theme = $layout_support['_theme'];
        }

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

    function notify($text, $object = null, $sender = null) {
        $this->loadModel('Notification');
        $data = array('Notification' => array(
            'sender' => 'User/1',
            'object' => $object->name.'/'.$object->id,
            'text' => $object->name.'/'.$object->id
        ));
        $this->Notification->save($data);
    }

    function save() {
        $model = Inflector::singularize($this->name);
        if (!empty($this->data)) {
            $this->$model->save($this->data);
            $this->notify($this->$model);
        }
    }

    function request($request_string, $redirect = false) {
        if (!empty($this->data)) {
            list($module, $model, $action) = explode('/', $request_string);
            App::import('Controller', 'Admin');
            $admin_controller = new AdminController();
            $admin_controller->constructClasses();
            $admin_controller->data = $this->data;
            $admin_controller->$action($module, $model, $this->data[$model]['id'], false);
            $this->redirect($redirect);
        }
    }

    function addBreadcrumb($text, $link, $id=false) {
        if (!$id)
            $id = sizeof($this->breadcrumbs);
        $link = Router::url($link);
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

    function template() {
        $this->autoRender = false;
        $files = func_get_args();
        App::import('View', $this->view);
//        echo '<pre>';
//        print_r($files);
//        die;
        $viewClassName = $this->view . 'View';
        $View = new $viewClassName($this);
        $paths = $View->_paths();

        foreach ($paths as $path) {
            foreach ($files as $file) {
                if($file) {
                    $full_path = $path . $file . $this->ext;
                    if (file_exists($full_path)) {
                        return parent::render('/'.$file, null, null, false);
                        break;
                    }
                }
            }
        }
        
        return false;
    }

    function render($action = null, $layout = null, $file = null, $template_call = true) {
        if ($template_call) {
            $model = '';

            if($this->name == 'Viewer')
                $model = 'page';

            if (isset($this->params['model']))
                $model = $this->params['model'];
            
            $slug = '';
            if (isset($this->params['slug']))
                $slug = $this->params['slug'];

            $result = $this->template( $slug ? $model . '-' . $slug : '', $this->action ? $model . '-' . $this->action : '', $model);
            if($result)
                return $result;
            else
                return parent::render($action, $layout, $file);
        } else
            return parent::render($action, $layout, $file);
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
            if (strstr($action, '/')) {
                list($controller, $action) = explode('/', $action);
            } else
                $controller = '*';
            if (($controller == '*' || $this->name == $controller)
            && ($action == '*'||$this->action == $action))
                $result = true;
        }
        
        return $result;
    }

}