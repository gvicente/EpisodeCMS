<?php
	Configure::write('debug', 4);
	Configure::write('App.encoding', 'UTF-8');
	define('LOG_ERROR', 2);
	Configure::write('Session.save', 'php');
	Configure::write('Session.cookie', 'EPISODECMS');
	Configure::write('Session.timeout', '99999');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'medium');
	Configure::write('Security.salt', 'DYhG912SKLDJFH3b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');
	Cache::config('default', array('engine' => 'File'));
