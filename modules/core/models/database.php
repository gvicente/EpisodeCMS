<?php
	class Database extends AppModel {
		var $useTable = false;
		var $_schema = array(
			'host' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'user' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30)
		);
		
		
	}