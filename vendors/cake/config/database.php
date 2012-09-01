<?php
class DATABASE_CONFIG {

    var $default = array(
        'driver' => 'mysql',
        'persistent' => false,
        'host' => '',
        'login' => '',
        'password' => '',
        'database' => '',
        'prefix' => '',
        'encofing' => 'utf-8'
    );

}

$config = Configure::read('config');
if (!$config['setup']) {
    $_this =& ConnectionManager::getInstance();
    $_this->config->{'default'} = array_merge($_this->config->{'default'}, $config['database']);
}
