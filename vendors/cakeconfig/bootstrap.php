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

if ($config = load(ROOT . DS . 'config'))
    Configure::write('debug', @$config['debug'] || 0);

$modules = array();

if (isset($config['project'])) {
    $project_config = load(ROOT . DS . 'projects' . DS . $config['project'] . DS . 'project');

    if (!isset($project_config['version']))
        $project_config['version'] = 0;

    $config['modules'][$config['project']] = $project_config['version'];
    $config = array_extend($config, $project_config);
}

if (!@$config || !@$config['modules']['core'])
    $config['modules']['core'] = 0;

foreach ($config['modules'] as $module => $version) {
    $modules[$module] = load(ROOT . DS . 'modules' . DS . $module . DS . 'module');
    $controllerPaths[] = ROOT . DS . 'modules' . DS . $module;
    $modelPaths[] = ROOT . DS . 'modules' . DS . $module . DS . 'models';
    $viewPaths[] = ROOT . DS . 'modules' . DS . $module . DS . 'views' . DS;
    $helperPaths[] = ROOT . DS . 'modules' . DS . $module . DS . 'views' . DS . 'helpers' . DS;
    $componentPaths[] = ROOT . DS . 'modules' . DS . $module . DS . 'components' . DS;
    $localePaths[] = ROOT . DS . 'modules' . DS . $module . DS . 'locale' . DS;
}

if (isset($config['project'])) {
    $controllerPaths[] = ROOT . DS . 'projects' . DS . $config['project'];
    $modelPaths[] = ROOT . DS . 'projects' . DS . $config['project'] . DS . 'models';
    $viewPaths[] = ROOT . DS . 'projects' . DS . $config['project'] . DS . 'views' . DS;
    $helperPaths[] = ROOT . DS . 'projects' . DS . $config['project'] . DS . 'views' . DS . 'helpers' . DS;
    $componentPaths[] = ROOT . DS . 'projects' . DS . $config['project'] . DS . 'components' . DS;
    $localePaths[] = ROOT . DS . 'projects' . DS . $config['project'] . DS . 'locale' . DS;

    $modules[$config['project']] = $project_config;
}

Configure::write('modules', $modules);
Configure::write('config', $config);

$Folder = & new Folder();
$controllers = array();
foreach ($controllerPaths as $path) {
    $Folder->cd($path);
    $controllers = am(array_map('__controllerize', $Folder->find('.+_controller\.php$')), $controllers);
}

function __controllerize($file) {
    return Inflector::camelize(str_replace('_controller.php', '', $file));
}

Configure::write(compact('modules', 'controllers'));

App::build(array(
    'models' => $modelPaths,
    'views' => $viewPaths,
    'controllers' => $controllerPaths,
    'components' => $componentPaths,
    'helpers' => $helperPaths,
    'locales' => $localePaths
));
