<?php
	class EditorController extends AppController {
		var $uses = array();
        var $ui = "admin";

		function index() {
		
		}

        function _onStartupAdmin($event, $controller) {
			$controller->widget('navigation', 'site_map', array(), $this, array('*/*'));
		}
	}