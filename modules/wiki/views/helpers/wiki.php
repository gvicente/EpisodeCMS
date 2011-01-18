<?php 
class WikiHelper extends Helper {

    var $helpers = array('Textile');

    function process($text) {
        $result = $text;
        $result = $this->Textile->process($result);
        $result = preg_replace('/\[\[(.+)\]\]/i', '<a href="\\1">\\1</a>', $result);
        return $result;
    }

} 