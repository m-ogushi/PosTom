<h2>Edit event</h2>
<?php
echo $this->Form->create('',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('event_name', array('class'=>'form-control','default' => $datas["Event"]["event_name"]));
echo $this->Form->input('event_location', array('class'=>'form-control','default' => $datas["Event"]["event_location"]));
echo $this->Form->input('event_begin_date', array('class'=>'form-control','default' => $datas["Event"]["event_begin_date"]));
echo $this->Form->input('event_begin_time', array('class'=>'form-control','default' => $datas["Event"]["event_begin_time"]));
echo $this->Form->input('event_end_date', array('class'=>'form-control','default' => $datas["Event"]["event_end_date"]));
echo $this->Form->input('event_end_time', array('class'=>'form-control','default' => $datas["Event"]["event_end_time"]));
echo $this->Form->input('event_top_image', array('type'=>'file' ));
echo $this->Form->submit('Edit', array('class'=>'btn btn-custom'));
?>