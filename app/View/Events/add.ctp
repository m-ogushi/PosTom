<h2>Add event</h2>

<?php
echo $this->Form->create('Event');
echo $this->Form->input('event_name');
echo $this->Form->input('event_location');
echo $this->Form->input('event_begin_date');
echo $this->Form->input('event_end_date');
echo $this->Form->end('Save Event');
?>