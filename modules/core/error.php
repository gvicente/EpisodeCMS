<?php
	App::import('Core', 'Error');

	class AppError extends ErrorHandler {
	    function __construct($method, $messages) {
	        App::import('Core', 'Sanitize');
	        static $__previousError = null;

	        if ($__previousError != array($method, $messages)) {
	            $__previousError = array($method, $messages);
	            $this->controller =& new CakeErrorController();
	        } else {
	            $this->controller =& new Controller();
	            $this->controller->viewPath = 'errors';
	        }
	        
	        // @todo Подумать над решением:
//			$this->controller->theme = 'default';
			
	        $options = array('escape' => false);
	        $messages = Sanitize::clean($messages, $options);

	        if (!isset($messages[0])) {
	            $messages = array($messages);
	        }

	        if (method_exists($this->controller, 'apperror')) {
	            return $this->controller->appError($method, $messages);
	        }

	        if (!in_array(strtolower($method), array_map('strtolower', get_class_methods($this)))) {
	            $method = 'error';
	        }
	        $this->dispatchMethod($method, $messages);
	        $this->_stop();
	    }

	    function error404($params = array()) {
				extract($params, EXTR_OVERWRITE);

				if (!isset($url)) {
					$url = $this->controller->here;
				}

				$url = Router::normalize($url);

				$this->controller->set(array(
					'code' => '404',
					'name' => __('Not Found', true),
					'message' => h($url),
					'base' => $this->controller->base
				));
				$this->controller->pageTitle = __('Not Found', true);
				$this->_outputMessage('error404');
			}

	    function missingAction($params) {
	    	$config = Configure::read('config');
	    	if($config['setup']) {
	    		$this->controller->redirect('/');
	    	} elseif(!isset($config['debug']) && $config['debug']<1)
	    		$this->error404();
	    	else
	    		parent::missingAction($params);
	    }

	    function missingConnection($params) {
	    	$this->maintance();
	    }

	    function missingController($params) {
	    	$config = Configure::read('config');
	    	if(isset($config['debug']) && $config['debug']>1)
	    		parent::missingController($params);
	    	else
                $this->error404();
	    		
	    }

	    function missingTable($params) {
	    	$config = Configure::read('config');
	    	if(!isset($config['debug']) && $config['debug']<1)
	    		$this->maintance('Page');
	    }

	    function maintance($type='Site', $time = null) {
	    	$this->controller->pageTitle = 'Maintance';
	    	$this->controller->set(compact('time', 'type'));
	    	$this->_outputMessage('maintance');
	    }
	}