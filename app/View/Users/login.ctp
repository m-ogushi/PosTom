<h2>Sign In</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->end('Sign In');
?>
