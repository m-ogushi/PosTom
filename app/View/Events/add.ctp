<h2>Add event</h2>

<?php
echo $this->Form->create('Event');
echo $this->Form->input('event_name', array('class'=>'form-control'));
echo $this->Form->input('event_location', array('class'=>'form-control'));
echo $this->Form->input('event_begin_date', array('class'=>'form-control'));
echo $this->Form->input('event_end_date', array('class'=>'form-control'));
echo $this->Form->submit('Save Event', array('class'=>'btn btn-custom'));
?>