<?php
	class ViewerController extends AppController {
		var $uses = array();

		function index($model) {
			$this->loadModel($model);
			$this->set(compact('model'));
			$data = $this->$model->find('all');
			foreach($data as $id=>$entry) {
				$this->Event->triggerEvent($model.'View', $data[$id]);
			}
			$this->set(compact('data'));
			$this->set('title_for_layout', __(Inflector::humanize(Inflector::tableize($model)), true));
			$this->set('json', array('data'));
		}

		function home() {
			$this->set('title_for_layout', __('Welcome', true));
		}

		function view($model, $slug) {
			$this->loadModel($model);
			$data['model'] = $model;
			$data['entry'] = $this->$model->findBySlug($slug);
            $this->Event->triggerEvent('ViewerView', $data['entry']);
			$this->Event->triggerEvent($model.'View', $data['entry']);

			if(@$data['entry'][$model]['title'])
				$this->set('title_for_layout', $data['entry'][$model]['title']);
			else
				$this->set('title_for_layout', Inflector::humanize($slug));

			$this->set(compact('data'));
			return $data;
		}

		function uploadPhoto() {
			$this->autoRender = false;
			Configure::write('debug', 0);

			list($name, $ext) = explode('.', basename($_FILES['userfile']['name']));
			$filename = '/public/'.md5($name).'.'.$ext;
			$uploadfile = ROOT.$filename;

			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			  echo $filename;
			} else {
			  echo "error";
			}
		}
	}