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
				$config['modules']['core'] = 0;
				save(ROOT.DS.'config', $config);
				$cachePaths = array('views', 'persistent', 'models');
				foreach($cachePaths as $cache) {
					clearCache(null, $cache);
				}
				$this->Session->setFlash('Connected to database');
				$this->redirect('/admin/');
			}
		}

		function site() {

		}
	}