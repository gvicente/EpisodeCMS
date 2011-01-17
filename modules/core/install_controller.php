    <?php
class InstallController extends AppController {
	var $ui = "install";
	var $uses = array('Database', 'User');

	function beforeFilter() {

        if (!$database = $this->Session->read('database'))
            $database = array(
                'host'=>'localhost',
                'database'=>'site',
                'create_on_install'=>true,
                'login'=>'root',
                'password'=>''
            );

        if (!$user = $this->Session->read('user'))
            $user['User'] = array(
                'login' => 'admin',
                'password' => ''
            );
        
        if (!$project = $this->Session->read('project'))
            $project = false;

		$this->database = $database;
        $this->user     = $user;
        $this->project  = $project;
	}

	function beforeRender() {
        
	}

	function index() {
		if (!isset($this->data['Database'])) {
			$this->data['Database'] = $this->database;
		} else {
			$this->Session->write('database', $this->data['Database']);
			if ($this->isAbleToConnect($this->database)) {
                $this->redirect(array('action'=>'user'));
            } else {
                $this->Session->setFlash('No connection with database');
            }
		}
	}

	function user() {
        if (!isset($this->data['User'])) {
			$this->data = $this->user;
		} else {
			$this->Session->write('user', $this->data);
			$this->redirect(array('action'=>'project'));
		}
	}

    function project() {
        if (!isset($this->data['Project'])) {
			$Folder = & new Folder();
            $Folder->cd(ROOT.DS.'projects');
            $paths = $Folder->read(true);
            $paths = $paths[0];

            foreach ($paths as $path)
                $projects[$path] = load(ROOT.DS.'projects'.DS.$path.DS.'project');

            $this->set(compact('projects'));
		} else {
			$this->Session->write('project', $this->data['Project']['id']);
			$this->redirect(array('action'=>'run'));
		}
    }

    function isAbleToConnect($config) {

        $connected = @mysql_connect($config['host'], $config['login'], $config['password']);
        return $connected;
    }

    function run() {
        $this->autoRender = false;
        $config['project'] = $this->project;
        $config['database'] = $this->database;
        $connected = $this->isAbleToConnect($config['database']);

        if($connected) {
            $database_exists = false;

            if($config['database']['create_on_install'] == true) {
                if($database_exists = mysql_select_db($config['database']['database'])) {
                  mysql_query("DROP DATABASE {$config['database']['database']}");
                }

                $database_exists = mysql_query("CREATE DATABASE {$config['database']['database']}");

                unset($config['database']['create_on_install']);
            }

            if($connected && $database_exists) {
                
                $cachePaths = array('views', 'persistent', 'models');
                foreach($cachePaths as $cache) {
                    clearCache(null, $cache);
                }

                Configure::write('config', $config);

                $_this =& ConnectionManager::getInstance();
                $_this->config->{'default'} = array_merge($_this->config->{'default'}, $config['database']);

                App::import('Controller', 'Admin');

                $admin_controller = new AdminController();
                $admin_controller->constructClasses();
                $project = load(ROOT.DS.'projects'.DS.$this->project.DS.'project');

                $admin_controller->install('core', false, false);
                foreach ($project['modules'] as $module => $version) {
                    $admin_controller->install($module, false, false);
                }
                
                $this->user['User']['id'] = 0;
                $admin_controller->data = $this->user;
                
                @$admin_controller->edit('core', 'User', null, false);
                
                save(ROOT.DS.'config', $config);
                $this->redirect('/admin/');
            } else {
                $this->Session->setFlash('There was problem to work with database');
                $this->redirect('/');
            }
        } else {
            $this->Session->setFlash('No connection to databse');
            $this->redirect('/');
        }
    }
}