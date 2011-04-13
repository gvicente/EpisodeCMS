<?php
	class GalleryController extends AppController {
		function _onWidgetGalleryLatest($event, $controller) {
			$this->loadModel('Gallery');
            $galleries = $this->Gallery->find('all');
            return $galleries;
		}
	}