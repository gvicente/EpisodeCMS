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
						'name'=>'site',
						'create_on_install'=>true,
						'user'=>'root',
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
			$this->data['Database']['host'] 	= @$this->default['database']['host'];
			$this->data['Database']['name'] 	= @$this->default['database']['name'];
			$this->data['Database']['user'] 	= @$this->default['database']['user'];
			$this->data['Database']['password']	= @$this->default['database']['password'];
		} else {
			$this->Session->write('database', $this->data['Database']);
			$config['database'] = $this->data['Database'];
			
			$connected = false;
			$database_exists = false;
			
			$connected = mysql_connect($config['database']['host'], $config['database']['user'], $config['database']['password']);
			if($connected) {
				if($config['database']['create_on_install'] == true) {
					try {
					   $database_exists = !mysql_query("CREATE DATABASE `{$config['database']['name']}`;");
					} catch(Exception $exception) {
						
					}
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
					
					require_once "admin_controller.php";

					// @todo: Подключиться к базе
//					DATABASE_CONFIG
					
			        $admin_controller = new AdminController();
			        $admin_controller->install('core', '/admin/');
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