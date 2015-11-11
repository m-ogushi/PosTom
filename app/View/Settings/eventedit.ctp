<h2>Edit event</h2>
<?php
echo $this->Form->create('',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('event_name', array('class'=>'form-control','default' => $datas["Event"]["event_name"],'required' => false));
echo $this->Form->input('event_location', array('class'=>'form-control','default' => $datas["Event"]["event_location"],'required' => false));
echo $this->Form->input('event_begin_date', array('class'=>'form-control','default' => $datas["Event"]["event_begin_date"],'required' => false));
echo $this->Form->input('event_begin_time', array('class'=>'form-control','default' => $datas["Event"]["event_begin_time"],'required' => false));
echo $this->Form->input('event_end_date', array('class'=>'form-control','default' => $datas["Event"]["event_end_date"],'required' => false));
echo $this->Form->input('event_end_time', array('class'=>'form-control','default' => $datas["Event"]["event_end_time"],'required' => false));
echo $this->Form->input('event_top_image', array('type'=>'file','required' => false));
echo $this->Form->submit('Edit', array('class'=>'btn btn-custom'));
?>