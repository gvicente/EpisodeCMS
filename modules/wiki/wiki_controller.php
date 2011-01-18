<?php
class WikiController extends AppController {
    var $ui = "main";

    function admin_index() {
        $this->ui = "admin";
        $this->set('wikis', $this->Wiki->find('all'));
    }

    function admin_view($title=null) {
        $this->loadHelper('Wiki');
        $this->ui = "admin";
        $wiki = $this->Wiki->findByTitle($title);
        $this->set(compact('wiki', 'title'));
    }

    function admin_edit($title=null) {
        if (!empty($this->data)) {
            $admin_controller = $this->loadConsole($this);
            $admin_controller->edit('wiki', 'Wiki', $this->data['Wiki']['id'], false);
//            $this->defaultAction('Wiki/edit', array('action'=>'admin_view', 'title'=>$this->data['Wiki']['title']));
            $this->redirect(array('action'=>'admin_view', 'title'=>$this->data['Wiki']['title']));
        }
        $this->admin_view($title);
    }

    function admin_delete($title=null) {
        $wiki = $this->Wiki->findByTitle($title);
        $this->Wiki->delete($wiki['Wiki']['id']);
        $this->redirect(array('action'=>'admin_index'));
    }
}