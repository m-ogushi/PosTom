<h2>Sign Up</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name', 'class'=>'form-control'));
echo $this->Form->input('email', array('label' => 'Mail Address', 'class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'Password', 'class'=>'form-control'));
echo $this->Form->input('password_confirm', array('label' => 'Password(Confirm)', 'type' => 'password', 'class'=>'form-control'));
echo $this->Form->submit('Sign Up', array('class'=>'btn btn-custom'));
?>
