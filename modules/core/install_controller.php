<?php
class InstallController extends AppController {
	var $theme = "_classic";
	var $uses = array('Database');

	function beforeFilter() {
		if(!$sample['database'] = $this->Session->read('database'))
			if(!$sample = load(TMP.DS.'config.bak'))
				if(!$sample = load(ROOT.DS.'modules'.DS.'core'.DS.'config.default')) {
					$sample['database'] = array(
						'host'=>'localhost',
						'database'=>'site',
						'create_on_install'=>true,
						'login'=>'root',
						'password'=>''
					);
				}
				
		$this->default = $sample;

		$this->menu = array(
			'Database'=>array('@link'=>'/index')
		);
	}

	function beforeRender() {
		$this->set('menu', $this->menu);
		$this->set('page_name', 'Setup');
	}

	function index() {
		if(!isset($this->data['Database'])) {
			$this->data['Database'] = $this->default['database'];
		} else {
			$this->Session->write('database', $this->data['Database']);
			$config['database'] = $this->data['Database'];
			
			$connected = false;
			$database_exists = false;
			$connected = mysql_connect($config['database']['host'], $config['database']['login'], $config['database']['password']);
			if($connected) {
				if($config['database']['create_on_install'] == true) {
					if($database_exists = mysql_select_db($config['database']['database'])) {
					  mysql_query("DROP DATABASE {$config['database']['database']}");	
					}
					
					$database_exists = mysql_query("CREATE DATABASE {$config['database']['database']}");

					unset($config['database']['create_on_install']);
				}
				
				if($connected && $database_exists) {
					save(ROOT.DS.'config', $config);
					$cachePaths = array('views', 'persistent', 'models');
					foreach($cachePaths as $cache) {
						clearCache(null, $cache);
					}
					
					// @todo: Найти другой способ генерации данных
					Configure::write('config', $config);
					
					$_this =& ConnectionManager::getInstance();
					$_this->config->{'default'} = array_merge($_this->config->{'default'}, $config['database']);
					 
					require_once "admin_controller.php";

			        $admin_controller = new AdminController();
			        $admin_controller->install('core', false);
			        
			        $admin_controller->data = array(
			             'username'=>'admin',
			             'password'=>Security::hash('admin')
			        );
			        
			        $admin_controller->edit('core', 'User', null, false);
			        
			        $this->redirect('/admin/customize/core');
				} else {
					$this->Session->setFlash('Problem with database');
                    $this->redirect('/');
				}
			} else {
				$this->Session->setFlash('No connection to server');
				$this->redirect('/');
			}
		}
	}

	function site() {

	}
}