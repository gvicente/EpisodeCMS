<?php echo $this->Form->create('Subscriber', array('url'=>'/newsletter')) ?>
<?php echo $this->Form->input('name') ?>
<?php echo $this->Form->input('email') ?>
<?php echo $this->Form->end('Subscribe') ?>