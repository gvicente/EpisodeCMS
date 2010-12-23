<?php

App::import('vendor', 'spyc');

function array_extend($a, $b) {
    foreach ($b as $k => $v) {
        if (is_array($v)) {
            if (!isset($a[$k])) {
                $a[$k] = $v;
            } else {
                $a[$k] = array_extend($a[$k], $v);
            }
        } else {
            $a[$k] = $v;
        }
    }
    return $a;
}

function load($file) {
    if (file_exists($file . '.yml')) {
        $data = Spyc::YAMLLoad($file . '.yml');
        if (sizeof($data) > 0)
            return $data;
        else
            return false;
    } else
        return false;
}

function save($file, $array) {
    $string = Spyc::YAMLDump($array);

    //		$f = fopen('ftp://razbakov:V3ufG0k1c@localhost'.$file, "w");
    //		fwrite($f, $string);
    //		fclose($f);

    file_put_contents($file . '.yml', $string);
}

function __controllerize($file) {
    return Inflector::camelize(str_replace('_controller.php', '', $file));
}

function __helperize($file) {
    return Inflector::camelize(str_replace('.php', '', $file));
}

if ($config = load(ROOT . DS . 'config'))
    Configure::write('debug', @$config['debug'] || 0);

$modules = array();

if (isset($config['project'])) {
    $project_config = load(ROOT . DS . 'projects' . DS . $config['project'] . DS . 'project');

    if (!isset($project_config['version']))
        $project_config['version'] = 0;

    $config['modules'][$config['project']] = $project_config['version'];
    $config = array_extend($config, $project_config);
} else {
    $config['project'] = false;
}

if (!@$config || !@$config['modules']['core'])
    $config['modules']['core'] = 1;

foreach ($config['modules'] as $module => $version) {
    if($config['project'] == $module) {
        $directory = 'projects';
        $modules[$config['project']] = $project_config;
    } else {
        $directory = 'modules';
        $modules[$module] = load(ROOT . DS . $directory . DS . $module . DS . 'module');
    }
    
    $modules[$module]['path'] = '/'.$directory.'/' . $module;
    $controllerPaths[] = ROOT . DS . $directory . DS . $module;
    $modelPaths[] = ROOT . DS . $directory . DS . $module . DS . 'models';
    $viewPaths[] = ROOT . DS . $directory . DS . $module . DS . 'views' . DS;
    $helperPaths[] = ROOT . DS . $directory . DS . $module . DS . 'views' . DS . 'helpers' . DS;
    $componentPaths[] = ROOT . DS . $directory . DS . $module . DS . 'components' . DS;
}

Configure::write('modules', $modules);
Configure::write('config', $config);

$Folder = & new Folder();
$controllers = array();
foreach ($controllerPaths as $path) {
    $Folder->cd($path);
    $controllers = am(array_map('__controllerize', $Folder->find('.+_controller\.php$')), $controllers);
}

Configure::write(compact('modules', 'controllers'));

App::build(array(
    'models' => $modelPaths,
    'views' => $viewPaths,
    'controllers' => $controllerPaths,
    'components' => $componentPaths,
    'helpers' => $helperPaths,
    'locales' => TEMP . 'cache' . DS . 'translations' . DS
));
