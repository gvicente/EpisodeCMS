<?php
	class NotificationsController extends AppController {
		var $uses = array('Notification');
		var $ui   = "admin";
        
		function index() {
        	$data = $this->Notification->find('all', array('conditions'=>array('read'=>0), 'order'=>'text'));
			$ids = array();
			$modules = array();
			foreach($data as $key=>$notification) {
				list($senderModel, $senderId) = explode('/', $notification['Notification']['sender']);
				$this->loadModel($senderModel);

				list($objectModel, $objectId) = explode('/', $notification['Notification']['object']);
				$this->loadModel($objectModel);

				list($textModel, $textId) = explode('/', $notification['Notification']['text']);
				$this->loadModel($textModel);

				$current = array(
					'Sender' => $this->$senderModel->findById($senderId),
					'Object' => $this->$objectModel->findById($objectId),
					'Text' => $this->$textModel->findById($textId),
					'id' => $notification['Notification']['id']
				);
                if(!$current['Text']) {
                    $this->Notification->delete($notification['Notification']['id']);
                } else {
                    $data[$textModel][] = $current;
                }

				$ids[$textModel][] = $notification['Notification']['id'];

				unset($data[$key]);
			}

			foreach($ids as $model=>$id) {
				$ids[$model] = join(',', $id);
			}

			$notifications = array();
			$modules = Configure::read('modules');
			foreach($modules as $config) {
				if(isset($config['notifications'])) {
					$notifications = array_extend($notifications, $config['notifications']);
				}
			}

			$this->set(compact('data', 'notifications', 'ids'));
		}
		
		function delete($ids=null) {
			if($ids!=null) {
				$ids = explode(',', $ids);
				foreach($ids as $id) {
					$this->Notification->delete($id);
				}
			}
			$this->redirect(array('action'=>'index'));
		}
	}
?>