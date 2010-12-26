<?php
	class DevController extends AppController {
		var $uses = array();
        var $ui = "admin";
		
		function index() {
			
		}
		
		function _onInstallDev() {
			Configure::write('config.debug', 4);			
		}
	
		function _onUninstallDev() {
			Configure::delete('config.debug');
		}
	}