<?php 
	class StatisticsController extends AppController {
		function _onAdminInit($event, $controller) {
			$controller->widget('navigation', 'widget', array(), $this, array('Notifications/index'));
		}
	}