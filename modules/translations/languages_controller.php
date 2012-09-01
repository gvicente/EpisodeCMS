<?php
	class LanguagesController extends AppController {
		function _onAdminInit($event, $controller) {
			$controller->widget('widgets', 'widget', array(), $this);
		}
	}