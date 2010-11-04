<?php
	class Database extends AppModel {
		var $useTable = false;
		var $_schema = array(
			'host' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'create_on_install' => array('type'=>'boolean', 'null' => true, 'default' => true),
			'user' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30)
		);
		
		
	}