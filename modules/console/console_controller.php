<?php
App::import('Controller', 'Admin');

class ConsoleController extends AdminController {
	var $uses = array();

	function beforeFilter() {
		parent::beforeFilter();
		if(Configure::read('config.console-theme'))
			$this->theme = Configure::read('config.console-theme');
		else
			$this->theme = "console";

		Configure::write('Config.language', Configure::read('config.console-language'));

		$modules = Configure::read('modules');
			
		$menu = array();
		foreach($modules as $config) {
			if(isset($config['admin'])) {
				$menu = array_extend($menu, $config['admin']);
			}
		}
			
		$this->widget('status', '../users/admin');
		$this->widget('status', '../admin/languages');
			
		$this->Event->triggerEvent('AdminInit');

		$this->set('layout_title', 'Console');
		$this->set('layout_redirect', array('controller'=>'console', 'action'=>'index'));
		$this->set(compact('menu'));
	}
}