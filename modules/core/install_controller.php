<?php
	class InstallController extends AppController {
		var $theme = "admin";
		var $uses = array('Database');
		
		function beforeFilter() {
			if(!$sample['database'] = $this->Session->read('database'))
				if(!$sample = load(TMP.DS.'config.bak.yml'))
					if(!$sample = load(ROOT.DS.'modules'.DS.'core'.DS.'config.default.yml')) {
						$sample['database'] = array(
							'host'=>'localhost',
							'user'=>'root',
							'database'=>'site',
							'password'=>''
						);			
					}
			$this->default = $sample;
			
			$this->menu[] = array('title'=>'<em>1</em> Database',				'action'=>'index');
			$this->menu[] = array('title'=>'<em>2</em> Site Information',		'action'=>'site');
			$this->menu[] = array('title'=>'<em>3</em> Administrator',			'action'=>'admin');
			$this->menu[] = array('title'=>'<em>4</em> Import Sample Data',	'action'=>'import');
		}
		
		function beforeRender() {
			foreach($this->menu as $k=>$menu) {
				if($menu['action'] == $this->action) {
					$this->menu[$k]['active'] = true;
				}
			}
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
				save(ROOT.DS.'config.yml', $config);
				$this->Session->setFlash('Connected to database');
				$this->redirect('/admin/');
			}
		}
		
		function site() {
			
		}
	}