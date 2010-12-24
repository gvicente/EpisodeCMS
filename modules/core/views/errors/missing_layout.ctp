<h2><?php __('Missing Layout'); ?></h2>
<p class="error">
	<strong><?php __('Error'); ?>: </strong>
	<?php printf(__('The layout file %s can not be found or does not exist.', true), '<em>' . $file . '</em>'); ?>
</p>
<p class="error">
	<strong><?php __('Error'); ?>: </strong>
	<?php printf(__('Confirm you have created the file: %s', true), '<em>' . $file . '</em>'); ?>
</p>
<p class="notice">
	<strong><?php __('Notice'); ?>: </strong>
	<?php printf(__('If you want to customize this error message, create %s', true), APP_DIR . DS . 'views' . DS . 'errors' . DS . 'missing_layout.ctp'); ?>
</p>