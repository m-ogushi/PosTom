<h2>Sign Up</h2>
<p class="attention">* : Required</p>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name', 'required' => false, 'class'=>'form-control required'));
echo $this->Form->input('email', array('label' => 'Mail Address', 'type' => 'text', 'required' => false, 'class'=>'form-control required'));
echo $this->Form->input('password', array('label' => 'Password', 'required' => false, 'class'=>'form-control required'));
echo $this->Form->input('password_confirm', array('label' => 'Password(Confirm)', 'type' => 'password', 'required' => false, 'class'=>'form-control required'));
echo $this->Form->submit('Sign Up', array('class'=>'btn btn-custom'));
?>
