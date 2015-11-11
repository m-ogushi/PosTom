<h2>Sign Up</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name', 'required' => false));
echo $this->Form->input('email', array('label' => 'Mail Address', 'type' => 'text', 'required' => false));
echo $this->Form->input('password', array('label' => 'Password', 'required' => false));
echo $this->Form->input('password_confirm', array('label' => 'Password(Confirm)', 'type' => 'password', 'required' => false));
echo $this->Form->end('Sign Up');
?>
