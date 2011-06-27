<?php
class WidgetsController extends AppController {
    function update() {

    }

    function translations() {
        
    }

    function _showBlock($slug) {
        $this->loadModel('Block');
        $block = $this->Block->findBySlug($slug);
        if (!$block) {
            $data['Block']['slug'] = $slug;
            $data['Block']['title'] = $slug;
            $this->Block->save($data);
        }
        return $this->renderPartial('block', $block);
    }
}