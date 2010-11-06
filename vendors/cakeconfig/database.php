<?php

$config = Configure::read('config');

eval("
	class DATABASE_CONFIG {
	
		var \$default = array(
			'driver' => 'mysql',
			'persistent' => false,
			'host' => '".$config['database']['host']."',
			'login' => '".$config['database']['login']."',
			'password' => '".$config['database']['password']."',
			'database' => '".$config['database']['database']."',
			'prefix' => '',
		);
		
	}
");