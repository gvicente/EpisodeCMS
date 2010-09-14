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
<h2>Welcome!<br>Please identify yourself.</h2>
<form method="post" action="<?php echo $html->url('/login/');?>">
	<fieldset>
	<?php echo $form->input('User.username', array('value'=>$this->data['User']['username'])); ?>
	<?php echo $form->input('User.password', array('value'=>$this->data['User']['password'])); ?>
	<?php echo $form->input('User.remember_me', array('type'=>'checkbox')); ?>
	</fieldset>
	<?php echo $form->end('Login'); ?>
</form>