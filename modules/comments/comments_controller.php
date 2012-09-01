<?php
	class CommentsController extends AppController {
        function _onViewerView($event, $controller) {
			$this->loadModel('Comment');
            $model = Inflector::humanize($controller->params['model']);
            $slug = $controller->params['slug'];
            $this->loadModel($model);

            $record = $this->$model->find('first', array('slug'=>$slug));
            if(isset($record[$model]['id'])) {
                $parent = $model.'/'.$record[$model]['id'];

                $comments = $this->Comment->find('all', array('conditions' => array('parent' => $parent), 'order' => 'Comment.created ASC'));
                $fields = Configure::read('modules.comments.models');
                $controller->widget('viewerafter', 'view', compact('comments', 'url', 'fields', 'parent'), $this, array('*/view'));
            }
		}

        function add() {
            $this->save();
            $this->redirect($this->referer());
        }
	}