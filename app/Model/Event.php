<?php

class Event extends AppModel {
	// イベント日数計算
    public function dayDiff(){
    	$event = $this->find('first');
        $begin = $event['Event']['event_begin_date'];
        $end = $event['Event']['event_end_date'];
        $timeStamp1 = strtotime($begin);
        $timeStamp2 = strtotime($end);
        $timeDiff = abs($timeStamp2 - $timeStamp1);
        $diff = ($timeDiff / (60 * 60 * 24)) + 1;
    	return $diff;
    }

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
