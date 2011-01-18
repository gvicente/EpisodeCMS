<?php
class WikiController extends AppController {
    var $ui = "main";

    function  beforeFilter() {
        parent::beforeFilter();
        $this->addBreadcrumb(__('Wiki', true), '/admin/wiki', 'root_module');
    }

    function admin_index() {
        $this->removeBreadcrumb('root_module');
        $this->ui = "admin";
        $this->set('wikis', $this->Wiki->find('all', array('conditions'=>array('parent_id'=>0))));
    }

    function admin_view($title=null) {
        if (!$title)
            $this->redirect('/admin/wiki');
        $this->loadHelper('Wiki');
        $this->ui = "admin";
        
        $title_array = explode('/', $title);
        $current_title = array_pop($title_array);
        $parent_title = array_pop($title_array);
        $parent_id = 0;

        if ($parent_title) {
            $parent = $this->Wiki->findByTitle($parent_title);
            $parent_id = $parent['Wiki']['id'];
            $this->addBreadcrumb($parent_title, '/admin/wiki/view/'.$parent_title);
        }

        $wiki = $this->Wiki->find(array('title'=>$current_title, 'parent_id'=>$parent_id));
        $redirect = $this->referer();
        $this->set(compact('wiki', 'title', 'current_title', 'parent_id', 'redirect'));
    }

    function admin_edit($title=null) {
        if(isset($this->data['redirect']))
            $redirect = $this->data['redirect'];
        else
            $redirect = '/admin/wiki';
        $this->request('Wiki/edit', $redirect);
        $this->admin_view($title);
    }

    function admin_delete($title=null) {
        $title_array = explode('/', $title);
        $current_title = array_pop($title_array);
        $parent_title = array_pop($title_array);
        $parent_id = 0;

        if ($parent_title) {
            $parent = $this->Wiki->findByTitle($parent_title);
            $parent_id = $parent['Wiki']['id'];
        }

        $wiki = $this->Wiki->find(array('title'=>$current_title, 'parent_id'=>$parent_id));
        $this->Wiki->delete($wiki['Wiki']['id']);

        if (!$parent_id)
            $this->redirect(array('action'=>'admin_index'));
        else
            $this->redirect(array('action'=>'admin_view', 'title'=>$parent['Wiki']['title']));
    }
}