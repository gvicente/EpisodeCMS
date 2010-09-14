<?php 
	class StatisticsController extends AdminController {
		function _onAdminInit($event, $controller) {
			$controller->widget('navigation', 'widget', array(), $this, array('Notifications/index'));
		}
	}