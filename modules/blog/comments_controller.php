<?php
	class CommentsController extends AppController {
		function _onPostView($event, $controller) {
			$this->loadModel('Comment');
			$comment_count = $this->Comment->find('count', array('conditions'=>array('post_id'=>$event->post['id'])));
			$href = array('action'=>'view', 'model'=>'post', 'slug'=>$event->post['slug']);
			$controller->widget('post'.$event->post['id'].'bottom', 'index', compact('comment_count', 'href'), $this, array('*/index'));
			$controller->widget('post'.$event->post['id'].'after', 'view', compact('comment_count'), $this, array('*/view'));
		}
	}