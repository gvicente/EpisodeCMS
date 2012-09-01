<script>
	$(function(){
		$('#UserUsername').select();
		$('#UserUsername').keypress(function(e){
			if (e.keyCode == 13) {
				$('#UserPassword').select();
				e.preventDefault();
			}	
		}
		);
	});
</script>
<h2><?php __('Welcome!<br>Please identify yourself.') ?></h2>
<form method="post" action="<?php echo $html->url('/login/');?>">
	<fieldset>
	<?php echo $form->input('User.username', array('label'=>__('Username', true), 'value'=>$this->data['User']['username'])); ?>
	<?php echo $form->input('User.password', array('label'=>__('Password', true), 'value'=>$this->data['User']['password'])); ?>
	<?php echo $form->input('User.remember_me', array('label'=>__('Remember Me', true), 'type'=>'checkbox')); ?>
	</fieldset>
	<?php echo $form->end(__('Login', true)) ?>
</form>