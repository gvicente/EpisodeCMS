<?php
	class UsersController extends AppController {
        var $ui = 'login';

		function index() {

		}
        
        function language($locale = null) {
            $this->autoRender = false;
            if ($locale != null) {
                $this->Cookie->write('language', $locale);
            }
            $this->redirect($this->referer());
        }

		function logout() {
			$this->Auth->logout();
            $this->Cookie->delete('Auth.User');
			$this->redirect($this->Auth->logoutRedirect);
		}

		function login() {
            $this->removeBreadcrumb('root');
            $menus = array();
            Configure::write(compact('menus'));

			$this->set('title_for_layout', __('Authorization', true));
			$this->set('layout_title', __('Authorization', true));
			$this->set('layout_redirect', array('controller'=>'users', 'action'=>'login'));
			

            if(Configure::read('config.backend.theme'))
				$this->theme = Configure::read('config.backend.theme');

			if (!empty($this->data)) {
				$this->data['User']['password'] = Security::hash($_POST['data']['User']['password']);
				if($this->Auth->login(@$this->data['User'])) {
					$this->Session->delete('Message.auth');

					if (!empty($this->data['User']['remember_me'])) {
						$cookie = array();
						$cookie['username'] = $this->data['User']['username'];
						$cookie['password'] = $this->data['User']['password'];
						unset($this->data['User']['remember_me']);
						$this->Cookie->write('Auth.User', $cookie, true, '+99999');
					} else {
						$this->Cookie->delete('Auth.User');
					}

                    $this->redirect('/');
				} else {
					$this->data['User']['password'] = '';
                    $this->redirect($this->referer());
				}
			} else {
				$this->Auth->login($this->Cookie->read('Auth.User'));
			}
		}
	}