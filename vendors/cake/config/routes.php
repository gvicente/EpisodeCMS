<?php
$config = Configure::read('config');

if ($config['setup']) {
    Router::connect('/:action', array('controller' => 'install'));
    Router::connect('/', array('controller' => 'install'));
} else {
    $controllers = Configure::read('controllers');
    $x = explode('/', $_GET['url']);
    $x = Inflector::humanize($x[0]);
    if (!in_array($x, $controllers)) {
        //Router::connect('/:model/:slug', array('controller' => 'viewer', 'action' => 'view'), array('pass' => array('model', 'slug'), 'model' => '[^/]+', 'slug' => '[^/]+'));
    }

    Router::parseExtensions('json', 'rss', 'xml');
    $modules = Configure::read('modules');
    
    $routes = array();
    $config['modules'] = array_reverse($config['modules']);
    
    foreach ($config['modules'] as $module => $version) {
        if (isset($modules[$module]['routes'])) {
            foreach ($modules[$module]['routes'] as $url => $action) {
                if (strpos($url, ':'))
                    $routes = array_merge($routes, array($url => $action));
                elseif (isset($routes[$url])) {
                    $routes[$url] = $action;
                } else
                    $routes = array_merge(array($url => $action), $routes);
            }
        }
    }

    foreach ($routes as $url => $action) {
        $writeConfig = false;
        $configs = array();
        foreach ($action as $key => $param) {
            if (!is_int($key) && ($key == 'pass' || $writeConfig)) {
                $writeConfig = true;
                $configs[$key] = $param;
                unset($action[$key]);
            }
        }
        Router::connect($url, $action, $configs);
    }
}