<h2>Sign In</h2>

<div style="color:red">
<?php
echo $this->Html->para('attention',$this->Session->flash());
?>
</div>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'User Name', 'class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'Password', 'class'=>'form-control'));
echo $this->Form->submit('Sign In', array('class'=>'btn btn-custom'));
?>
