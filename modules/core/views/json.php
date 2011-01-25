<?php
App::import('View', 'Theme');
class JsonView extends ThemeView {
	function render() {
		Configure::write('debug', 0);
		if(isset($this->params['url']['html'])) {
			$paths = $this->_paths(Inflector::underscore($this->plugin));
			foreach($paths as $path) {
				if(file_exists($path.$this->params['controller'].DS.$this->params['action'].$this->ext)) {
					echo $this->_render($path.$this->params['controller'].DS.$this->params['action'].$this->ext, $this->viewVars);
				}
			}
            foreach($paths as $path) {
                if(file_exists($path.$this->params['controller'].DS.$this->params['action'].'.js')) {
                    $path = str_replace(ROOT, '', $path);
                    echo '<script>App.current = "'.'dev/'.$this->params['controller'].'/'.$this->params['action'].'";</script>';
                    echo '<script src="'.Router::url($path.$this->params['controller'].DS.$this->params['action']).'.js"></script>';
					break;
				}
			}
		} else {
			if(is_array($this->viewVars['json'])) {
				foreach($this->viewVars['json'] as $var) {
					$data[$var] = $this->viewVars[$var]; 
				}
				echo json_encode($data);	
			}
		}
	}
}
?>