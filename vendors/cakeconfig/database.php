<?php

$config = Configure::read('config');

eval("
	class DATABASE_CONFIG {
	
		var \$default = array(
			'driver' => 'mysql',
			'persistent' => false,
			'host' => '".$config['database']['host']."',
			'login' => '".$config['database']['user']."',
			'password' => '".$config['database']['password']."',
			'database' => '".$config['database']['name']."',
			'prefix' => '',
		);
		
	}
");