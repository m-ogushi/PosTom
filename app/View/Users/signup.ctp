<h2>Sign Up</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name'));
echo $this->Form->input('email', array('label' => 'Mail Address'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->input('password_confirm', array('label' => 'Password(Confirm)', 'type' => 'password'));
echo $this->Form->end('Sign Up');
?>
