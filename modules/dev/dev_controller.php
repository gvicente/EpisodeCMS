<?php
	App::import('Controller', 'Admin');
	
	class DevController extends AdminController {
		var $uses = array();
		
		function index() {
			
		}
		
		function install() {
			Configure::write('config.debug', 4);			
		}
	
		function uninstall() {
			Configure::delete('config.debug');
		}
	}