<?php
    class ViewerController extends AppController {
		var $uses = array();

		function index($model) {
			$this->loadModel($model);
			$this->set(compact('model'));
			$data = $this->$model->find('all');
			foreach($data as $id=>$entry) {
                foreach($entry[$model] as $field=>$value) {
                    preg_match_all('/(.*)<!-- pagebreak -->/', $value, $matches);
                    if($matches[0])
                        $data[$id][$model][$field] = $matches[0][0];
                }
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
            $modules = Configure::read('modules');
            $modelName = Inflector::humanize($model);
            foreach ($modules as $module) {
                if(isset($module['models'][$modelName])) {
                    $config = $module['models'][$modelName];
                    break;
                }
            }

            if(isset($config['_view']))
                $visible = $config['_view'];

//            $this->Event->triggerEvent('ViewerView', $data['entry']);
//			$this->Event->triggerEvent($model.'View', $data['entry']);

			if(@$data['entry'][$model]['title'])
				$this->set('title_for_layout', $data['entry'][$model]['title']);
			else
				$this->set('title_for_layout', Inflector::humanize($slug));
			$this->set(compact('data', 'visible'));
            foreach($data['entry'][$model] as $field=>$content) {
                $this->set($field, $content);
            }
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