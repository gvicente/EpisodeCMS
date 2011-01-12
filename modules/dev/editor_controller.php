<?php
	class EditorController extends AppController {
		var $uses = array();
        var $ui = "admin";

		function edit() {
            $args = func_get_args();
            $menu = $args[0];
            unset($args[0]);
            $url = '/'.implode('/', $args);

            $current = Router::parse($url);
            $actions = $this->_getActionsList();
            $menus = $this->_getMenuList($menu);
            $modules = $this->_getModulesList();
            $models = array('post'=>'Post', 'tag'=>'Tag', 'page'=>'Page');
            $title = '';
            if (isset($menus[$url]))
                $title = $menus[$url];
            
            $this->set(compact('actions', 'modules', 'models', 'current', 'title'));
		}

        function _getActionsList() {
            $modules = Configure::read('modules');
            $actions = array();
            foreach ($modules as $module) {
                if (isset($module['actions']) && is_array($module['actions'])) {
                    foreach ($module['actions'] as $controller=>$description) {
                        if (isset($description['_title']))
                            $module['actions'][$controller]['_title'] = __($description['_title'], true);
                        foreach ($description as $action=>$params) {
                            if (is_array($params) && isset($params['_title']))
                                $module['actions'][$controller][$action]['_title'] =  __($params['_title'], true);
                        }
                    }
                    $actions = array_extend($actions, $module['actions']);
                }
            }
            return $actions;
        }

        function _getMenuList($menu) {
            $theme = Configure::read('theme');
            $modules = Configure::read('modules');
            $modules = array_extend($modules, array('theme'=>$theme));
            $menus = array();
            foreach ($modules as $module) {
                if (isset($module['menu']) && is_array($module['menu']) &&
                    isset($module['menu'][$menu]) && is_array($module['menu'][$menu])) {
                    foreach ($module['menu'][$menu] as $id=>$description) {
                        if (isset($description['_link']) && $id != '_title')
                            $menus[$description['_link']] = __($id, true);
                    }
                }
            }
            return $menus;
        }

        function _getModulesList() {
            $modules_list = Configure::read('modules');
            $modules = array();
            foreach ($modules_list as $module => $data) {
                $modules[$module] = __($data['title'], true);
            }
            return $modules;
        }
        
	}