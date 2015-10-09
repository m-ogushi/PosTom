<?php

class Event extends AppModel {
	public $validate = array(
		'event_name' => array(
			'rule' => 'notEmpty'
		),
		'event_location' =>  array(
			'rule' => 'notEmpty'
		)
	);
}

?>