<?php
class WidgetsController extends AppController {
    function update() {

    }

    function translations() {
        
    }

    function _showBlock($slug) {
        $this->loadModel('Block');
        $block = $this->Block->findBySlug($slug);
        return $this->renderPartial('block', $block);
    }
}