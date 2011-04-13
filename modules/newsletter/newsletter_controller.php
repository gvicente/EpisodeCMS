<?php
class NewsletterController extends AppController {
    var $uses = array();

    function subscribe() {
        $this->loadModel('Subscriber');
        $this->autoRender = false;

        if ($this->data) {
            $this->Subscriber->save($this->data);
        }

        $this->redirect($this->referer());
    }
}