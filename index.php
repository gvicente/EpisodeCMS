<?php
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(__FILE__));
	define('APP_DIR', '.');
	define('CAKE_CORE_INCLUDE_PATH', ROOT. DS.'vendors'.DS);
	define('WEBROOT_DIR', basename(dirname(__FILE__)));
	define('WWW_ROOT', dirname(__FILE__) . DS);
	define('APP_PATH', ROOT . DS . APP_DIR . DS);
	define('CORE_PATH', CAKE_CORE_INCLUDE_PATH);
	define('CONFIGS', CAKE_CORE_INCLUDE_PATH.'cakeconfig'.DS);
	define('TEMP', ROOT.DS.'tmp'.DS);

	foreach(array(
		TEMP, 
		TEMP.'cache',
		TEMP.'cache'.DS.'persistent',
		TEMP.'cache'.DS.'models',
		TEMP.'cache'.DS.'views'		
	) as $folder) {
		file_exists($folder) || mkdir($folder, 0777, true); 
	} 	
	
	include(CORE_PATH . 'cake' . DS . 'bootstrap.php');

	$Dispatcher = new Dispatcher();
	$Dispatcher->dispatch();

	if (Configure::read() > 0) {
		echo "<!-- " . round(getMicrotime() - $TIME_START, 4) . "s -->";
	}
?>