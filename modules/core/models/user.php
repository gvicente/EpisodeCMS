<?php
	class User extends AppModel {
        var $useTable = false;
		var $_schema = array(
            'id' => array('type'=>'int', 'null' => false, 'default' => NULL, 'length' => 30),
            'email' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'username' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30)
		);
	}
?>