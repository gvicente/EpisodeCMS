<?php
class AdminController extends AppController {
    
    var $uses = array();
    
    function beforeFilter() {
        parent::beforeFilter();
        if(Configure::read('config.backend.theme'))
            $this->theme = Configure::read('config.backend.theme');
        else
            $this->theme = '_classic';
             
        $language = Configure::read('config.admin-language');
        Configure::write('Config.language', $language);

        $modules = Configure::read('modules');

        $menu = array();
        foreach($modules as $config) {
            if(isset($config['admin'])) {
                $menu = array_extend($menu, $config['admin']);
            }
        }
        
        $user_info = $this->Auth->user();
        $this->widget('status', '../users/admin', array('user'=>$user_info['User']));
        $this->widget('status', '../admin/languages', compact('language'));

        $this->Event->triggerEvent('AdminInit');

        // @todo: Не самый лучший образ проверять конфиги
        $config = Configure::read('config.modules.core');
        $config = is_array($config)?$config:null;
        $site_title = $config['title']?$config['title']:__('EpisodeCMS', true);
        $this->set(compact('site_title'));
        $this->set('layout_title', 'Control Panel');
        $this->set('layout_redirect', array('controller'=>'notifications', 'action'=>'index'));
        $this->set(compact('menu'));
    }

    function beforeRender() {
        parent::beforeRender();
        $this->set('title_for_layout', __('Control Panel', true).' → '.__($this->name, true));
    }

    function language($locale = null) {
        $this->autoRender = false;
        if($locale!=null) {
            $config = Configure::read('config');
            $config['admin-language'] = $locale;
            save(ROOT.DS.'config', $config);
        }
        $this->redirect($this->referer());
    }

    function overview() {

    }

    function index() {
        $modulesFolder = new Folder(ROOT . DS . 'modules');
        $modulesPaths = $modulesFolder->read();
        $haveModules = array();

        foreach($modulesPaths[0] as $module) {
            if($data = load(ROOT.DS.'modules'.DS.$module.DS.$module)) {
                $haveModules[$module] = $data;
            }
        }

        $installedModules = Configure::read('config.modules');

        foreach($installedModules as $module=>$version) {
            if(isset($haveModules[$module])) {
                $haveModules[$module]['installed'] = true;
                if(str_replace(".", "", $haveModules[$module]['version']) > str_replace(".", "", $version)) {
                    $haveModules[$module]['old'] = true;
                }
                $modules[$module] = $haveModules[$module];
            }
        }
        $modules = array_merge($modules, $haveModules);

        $this->set(compact('modules'));
    }

    function browse($module=null, $model=null) {
        
        // @todo Рефакторинг для демо
        $restricted = Configure::read('config.modules.core.demo') == true && $model == 'User';

        if($restricted)
            $this->Session->setFlash('You can not edit users in demo');

        if(Configure::read('config.modules.'.$module)) {
            $moduleConfig = Configure::read('modules.'.$module);
            if($model==null && @$moduleConfig['models'])
                foreach($moduleConfig['models'] as $currentModel=>$values) {
                    if(isset($values['@default'])) {
                        $model = $currentModel;
                        break;
                    }
                }
            $modules = Configure::read('modules');
            $config = array();
            foreach($modules as $k=>$v) {
                $config = array_extend($v, $config);
            }
        } else {
            $this->Session->setFlash('Module <strong>'.$module.'</strong> is not installed.');
            $this->redirect(array('controller'=>'admin', 'action'=>'index'));
        }

        if($model!=null) {
            $this->loadModel($model);
            if(@$config['models'][$model]['@relations'])
            foreach($config['models'][$model]['@relations'] as $widgetModel=>$params) {
                if($widgetModel[0]=='+') {
                    $widgetModel = Inflector::classify(str_replace('+', '', $widgetModel));
                    $this->loadModel($widgetModel);
                    foreach($config['models'][$widgetModel] as $field=>$values) {
                        if($field[0]!='@') {
                            $maincolumn = $field;
                            break;
                        }
                    }
                    $this->widget('navigation', 'widget', array('data'=>$this->$widgetModel->find('all'), 'model'=>$widgetModel, 'module'=>$module, 'maincolumn'=>$maincolumn));

                }
            };

            $this->loadModel($model);

            if(isset($config['models'][$model]['title']))
            $maincolumn = 'title';
            else
            foreach($config['models'][$model] as $field=>$values) {
                if($field[0]!='@') {
                    $maincolumn = $field;
                    break;
                }
            }

            $data = $this->$model->find('all');

            if(isset($config['models'][$model]['@browse'])) {
                foreach($config['models'][$model]['@browse'] as $field=>$type) {
                    foreach($data as $id=>$entry) {
                        $content = $type['content'];
                        preg_match_all('/{([^}]+)}/i', $content, $replacements);
                        foreach($replacements[1] as $replaceId=>$replaceField) {
                            if(strpos($replaceField, '|')) {
                                $options = explode('|', $replaceField);
                                $fieldName = $options[0];
                                unset($options[0]);
                                foreach($options as $option) {
                                    switch($option) {
                                        case('list'):
                                            $intersectModel = $model.$fieldName;
                                            $this->loadModel($fieldName);
                                            $this->loadModel($intersectModel);
                                            $intersectIds = $this->$intersectModel->find('list', array('fields'=>array($fieldName.'_id'), 'conditions'=>array($model.'_id'=>$entry[$model]['id'])));
                                            $$fieldName = $this->$fieldName->find('list', array('conditions'=>array('id'=>$intersectIds)));
                                            $content = str_replace($replacements[0][$replaceId], join(', ', $$fieldName), $content);
                                            break;
                                        case('teaser'):
                                            preg_match_all('!((<[^>]+>)([^<]+)(</[^>]+>))!', @$entry[$model][$fieldName], $matches);
                                            $value = join(' ', $matches[3]);
                                            $value = iconv('UTF-8','windows-1251',$value);
                                            $value = substr($value,0, 300);
                                            $value = iconv('windows-1251','UTF-8',$value);
                                            $content = str_replace($replacements[0][$replaceId], $value, $content);
                                            break;
                                        case('text'):
                                            preg_match_all('!((<[^>]+>)?([^<]+)(</[^>]+>)?)+!', @$entry[$model][$fieldName], $matches);
                                            $content = str_replace($replacements[0][$replaceId], join(' ', $matches[3]), $content);
                                            break;
                                    }
                                }
                            } else {
                                $content = str_replace($replacements[0][$replaceId], @$entry[$model][$replaceField], $content);
                            }
                        }
                        $data[$id][$model][$field] = $content;
                    }
                    $columns[$field] = $type['column'];
                }
            } else {
                $columns = array();
            }

            $this->set(compact('module','model', 'data', 'columns', 'maincolumn'));
            $this->set(array('static'=>isset($config['models'][$model]['@static'])));
        } else {
            $this->Session->setFlash('Module <strong>'.$module.'</strong> has no models.');
            $this->redirect(array('controller'=>'admin', 'action'=>'index'));
        }
    }

    function edit($module, $model, $id = null, $redirect = true) {
        $fields = Configure::read('modules.'.$module.'.models');

        if(!$fields[$model]) {
            $this->Session->setFlash('There is no model called <strong>'.$model.'</strong>');
            $this->redirect(array('controller'=>'admin', 'action'=>'index'));
        }

        $this->loadModel($model);
        $restricted = Configure::read('config.modules.core.demo') == true && $model == 'User';
        if($restricted)
            $this->Session->setFlash('You can not edit users in demo');
        if(!empty($this->data) && !$restricted) {
            foreach($fields[$model] as $field=>$type) {
                $type = str_replace('*', '', $type);
                if($type == 'password') {
                    if(!empty($this->data[$model][$field]))
                        $this->data[$model][$field] = Security::hash($this->data[$model][$field]);
                    else
                        unset($this->data[$model][$field]);
                }
            }

            $this->$model->save($this->data);
            $entryId = $this->$model->id;

            if(@$fields[$model]['@relations'])
            foreach($fields[$model]['@relations'] as $listKey=>$listAttributes) {
                if($listKey[0]=='+') {
                    $listField = str_replace('+', '', $listKey);
                    $listModel = Inflector::classify($listField);
                    $modelField = Inflector::underscore($model).'_id';
                    if(isset($this->data[$model][$listModel])) {
                        $this->loadModel($listModel);
                        $intersectModel = $model.$listModel;
                        $this->loadModel($intersectModel);

                        $this->$intersectModel->deleteAll(array($modelField=>$entryId));
                        if(@$this->data[$model][$listModel]) {
                            $ids = explode(',', $this->data[$model][$listModel]);

                            foreach($ids as $k=>$id) {
                                if((int)($id)==0) {
                                    $this->$listModel->save(array('title'=>$id, 'id'=>''));
                                    $inserted = $this->$listModel->id;
                                    $id = $inserted;
                                }

                                unset($intersectData);
                                $intersectData[$intersectModel]['id'] = null;
                                $intersectData[$intersectModel][$modelField] = $entryId;
                                $intersectData[$intersectModel][$listField.'_id'] = $id;

                                $this->$intersectModel->save($intersectData);
                            }
                        }
                    }
                }
            }
            if($redirect)
                 $this->redirect(array('controller'=>'admin', 'action'=>'browse', 'model'=>$model, 'module'=>$module));
        }

        $data = array();
        $ids = array();
        if($id!=null) {
            $ids = explode(',', $id);
        }

        if($ids)
        foreach($ids as $id) {
            $data[$id] = $this->$model->findById($id);
        }

        $this->data = reset($data);

        if(@$fields[$model]['@relations'])
        foreach($fields[$model]['@relations'] as $listKey=>$listAttributes) {
            $listField = $listKey;

            if($listField[0]=='+') {
                $listField = str_replace('+', '', $listField);

                $list = Inflector::tableize($listField);

                unset($fields[$model]['@relations'][$listKey]);

                $listModel = Inflector::classify($listField);

                $fields[$model]['@relations'][] = array(
                        'title' => $listModel,
                        'name' => $list,
                        'type' => 'many',
                        'view' => $listAttributes
                );

                $this->loadModel($listModel);
                $$list = $this->$listModel->find('list');
                $intersectModel = $model.$listModel;
                $this->loadModel($intersectModel);
                if(@$this->data[$model]['id']) {
                    $values = $this->$intersectModel->find('list', array('fields'=>array($listField.'_id'), 'conditions'=>array($model.'_id'=>$this->data[$model]['id'])));
                    $this->data[$model][$listModel] = join(',', $values);
                }

                $this->set(compact($list));
            }

        }
        $breadcrumbs = true;
        $this->set(compact('module','model', 'fields', 'ids', 'data', 'breadcrumbs'));
        $this->set(array('multiple'=>(sizeof($ids)>1?true:false)));
    }

    function delete($module, $model, $id = null) {
        $this->loadModel($model);
        $restricted = Configure::read('config.modules.core.demo') == true && $model == 'User';
        if($id!=null) {
            $ids = explode(',', $id);
        }

        if(@$ids)
        foreach($ids as $id) {
            if(!$restricted)
                $this->$model->delete($id);
        }

        $this->redirect(array('action'=>'browse', 'model'=>$model, 'module'=>$module));
    }

    function restore() {
        $modules = Configure::read('config.modules');
        foreach($modules as $module=>$version) {
            $this->uninstall($module, false);
            $this->install($module, false);
        }
        $this->autoRender = false;
        $this->redirect(array('action'=>'index'));
    }

    /*
     * TODO: Fix saving with dashes.
     */
    function install($module, $redirect=true) {
        $this->loadModel('Database');
        $data = load(ROOT.DS.'modules'.DS.$module.DS.$module);

        if(@$data['models']) {
            reset($data['models']);
            while (list($model, $fields) = each($data['models'])) {
                $tableName = Inflector::tableize($model);
                $fieldsSQL = '';
                reset($fields);
                while (list($field, $type) = each($fields)) {
                    switch($field) {
                        case('@default'):
                        case('@static'):
                        case('@browse'):
                            break;
                        case('@relations'):
                            foreach($type as $relationField=>$relationAttributes) {
                                if($relationField[0]=='+') {
                                    $relationField = str_replace('+', '', $relationField);
                                    $data['models'][Inflector::classify($model.'_'.$relationField)] = array(
                                    Inflector::underscore($model).'_id' => 'int',
                                    Inflector::underscore($relationField).'_id' => 'int'
                                    );
                                } else {
                                    $fields[$relationField.'_id'] = 'int';
                                }
                            }
                        case('@belongsTo'):
                            if(is_string($type)) {
                                $fields[Inflector::underscore($type).'_id'] = 'int';
                            }
                            break;
                        case('@hasAndBelongsToMany'):
                            if(is_string($type))
                            $data['models'][$model.$type] = array(
                            Inflector::underscore($model).'_id' => 'int',
                            Inflector::underscore($type).'_id' => 'int'
                            );
                            break;
                        default:
                            $default = "";
                            $type = str_replace('*', '', $type);
                            $type = str_replace('#', '', $type);
                            switch($type) {
                                case('html'):
                                    $type = 'TEXT';
                                    break;
                                case('thumb'):
                                case('photo'):
                                case('string'):
                                case('password'):
                                    $type = 'VARCHAR(255)';
                                    break;
                                case('bool'):
                                case('int'):
                                    $default = 0;
                                    break;
                                case('datetime'):
                                    $default = '0000-00-00';
                                    break;
                            }
                            $fieldsSQL .= ",\n\t`$field` $type DEFAULT '$default'";
                            break;
                    }
                }
                $sql = sprintf("CREATE TABLE IF NOT EXISTS `%s`(\n\t`id` INT NOT NULL AUTO_INCREMENT%s,\n\tPRIMARY KEY (`id`)\n) CHARSET=utf8;", $tableName, $fieldsSQL);
                $this->Database->query($sql);
            }
        }

        if(@$data['install']['sql']) {
            $sqls = explode(';', $data['install']['sql']);
            foreach($sqls as $sql)
            if($sql)
            $this->Database->query($sql);
        }

        if(@$data['install']['method']) {
            $method = explode('/',$data['install']['method']);
            $controller = @$method[1];
            if($controller && (class_exists($controller.'Controller') || include (ROOT.DS.'modules'.DS.$module.DS.$controller.'_controller.php')))
            $this->requestAction($data['install']['method']);
        }

        $config = Configure::read('config');
        $config['modules'][$module] = $data['version'];
        save(ROOT.DS.'config', $config);

        clearCache(null, 'models');

        if($redirect)
            $this->redirect(array('action'=>'index'));
    }

    function uninstall($module, $redirect=true) {

        $this->loadModel('Database');
        $data = load(ROOT.DS.'modules'.DS.$module.DS.$module);

        if(@$data['uninstall']['method'])
        $this->requestAction($data['uninstall']['method']);

        if(@$data['uninstall']['sql']) {
            $sqls = explode(';', $data['uninstall']['sql']);
            foreach($sqls as $sql)
            if($sql)
            $this->Database->query($sql);
        }
        if(@$data['models']) {
            reset($data['models']);
            while (list($model, $fields) = each($data['models'])) {
                $tableName = Inflector::tableize($model);

                reset($fields);
                while (list($field, $type) = each($fields)) {
                    switch($field) {
                        case('@hasAndBelongsToMany'):
                            if(is_string($type))
                            $data['models'][$model.$type] = array();
                            break;
                    }
                }
                $sql = sprintf("DROP TABLE IF EXISTS `%s`;", $tableName);
                $this->Database->query($sql);
            }
        }
        $config = Configure::read('config');
        unset($config['modules'][$module]);
        save(ROOT.DS.'config', $config);
        clearCache(null, 'models');

        if($redirect)
        $this->redirect(array('action'=>'index'));
    }

    function themes($name = null) {
        if(!empty($name)) {
            $config = Configure::read('config');
            $config['frontend']['theme'] = $name;
            save(ROOT.DS.'config', $config);
            $this->redirect(array('controller'=>'admin', 'action'=>'themes'));
        }

        $themesFolderHandler = new Folder(ROOT . DS . 'themes');
        $themesFolder = $themesFolderHandler->read();
        $themes = array();
        foreach($themesFolder[0] as $themeFolder) {
            unset($theme);
            if($theme = load(ROOT . DS . 'themes'.DS.$themeFolder.DS.'theme')) {
                if(file_exists(ROOT . DS . 'themes'.DS.$themeFolder.DS.'screenshot.png')) {
                    $theme['screenshot'] = '/themes/'.$themeFolder.'/screenshot.png';
                } else {
                    $theme['screenshot'] = false;
                }
                $themes[$themeFolder] = $theme;
            }
        }
        $current = Configure::read('config.frontend.theme');
        $this->set(compact('themes', 'current'));
    }

    function menus($name = null) {
        if($theme = load(ROOT . DS . 'themes'.DS.Configure::read('config.theme').DS.'theme')) {
            $menus = $theme['menus'];
            $links = Configure::read('config.menus');
        }
        $this->set(compact('menus', 'links'));
    }

    function customize($module = 'core') {
        
        if(!empty($this->data)) {
            $config = Configure::read('config');
            
            // @todo: Какое-то странное изваятельство
            if(is_array(Configure::read('config.modules.'.$module)))
                $config['modules'][$module] = array_extend(Configure::read('config.modules.'.$module), $this->data[$module]);
            else
                $config['modules'][$module] = $this->data[$module];
            save(ROOT.DS.'config', $config);
            $this->redirect(array('controller'=>'admin', 'action'=>'index'));
        }

        if(is_array($options = Configure::read('config.modules.'.$module)))
              $this->data[$module] = $options;
        if(!$fields[$module] = Configure::read('modules.'.$module.'.options')) {
            $this->Session->setFlash('Module <strong>'.$module.'</strong> has no options to customize');
            $this->redirect(array('controller'=>'admin', 'action'=>'index'));
        }

        $this->set(compact('module', 'fields'));
        $this->render('/admin/edit');
    }
}