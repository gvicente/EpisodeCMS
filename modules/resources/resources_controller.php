<?php
	class ResourcesController extends AppController {
		function _onWidgetResourcesList($event, $controller) {
			$this->loadModel('Resource');
            $resources = $this->Resource->find('all');
            return $resources;
		}
	}