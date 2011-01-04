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
    file_put_contents($file . '.yml', $string);
}

function __controllerize($file) {
    return Inflector::camelize(str_replace('_controller.php', '', $file));
}

function __helperize($file) {
    return Inflector::camelize(str_replace('.php', '', $file));
}

if ($config = load(ROOT . DS . 'config'))
    Configure::write('debug', isset($config['debug']) && $config['debug'] || 0);

$modules = array();
$ui = array();
$widgets = array();

if (isset($config['project'])) {
    $project_config = load(ROOT . DS . 'projects' . DS . $config['project'] . DS . 'project');

    if (!isset($project_config['version']))
        $project_config['version'] = 0;

    $config['modules'][$config['project']] = $project_config['version'];
    $config = array_extend($config, $project_config);
    $modules[$config['project']] = 1;
} else {
    $config['project'] = false;
}

$modules['core'] = 1;
$config['modules']['core'] = 1;

foreach ($config['modules'] as $module => $version) {
    if($config['project'] == $module) {
        $directory = 'projects';
        $modules[$config['project']] = $project_config;
        $modules[$config['project']]['package'] = 'project';
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

    if (isset($modules[$module]['ui']))
        $ui = array_extend($ui, $modules[$module]['ui']);
}

if (!isset($config['theme'])) {
    $config['theme'] = 'default';
}

foreach($controllerPaths as $path) {
    if(file_exists($path . DS . 'themes' . DS . $config['theme'] . DS . 'theme.yml')) {
        $config['theme_path'] = $path . DS . 'themes' . DS . $config['theme'];
        break;
    }
}

if(isset($config['theme_path'])) {
    $theme = load($config['theme_path'].DS.'theme');
    $theme['path'] = $config['theme_path'];
    $theme['path'] = str_replace(ROOT . DS, '/', $theme['path']);
    $theme['path'] = str_replace(DS, '/', $theme['path']);
}

Configure::write('modules', $modules);
Configure::write('config', $config);
Configure::write('theme', $theme);
Configure::write('ui', $ui);

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
