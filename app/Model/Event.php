<?php

class Event extends AppModel {
	public $validate = array(
		'event_name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please input 100 characters or less.'
		),
		'event_begin_date' =>  array(
			'rule' => 'notEmpty'
		),
		'event_begin_time' =>  array(
			'rule' => 'notEmpty'
		),
		'event_end_date' =>  array(
			'rule' => 'notEmpty'
		),
		'event_end_time' =>  array(
			'rule' => 'notEmpty'
		)
	);
}

?>