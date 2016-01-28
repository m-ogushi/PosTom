<?php
App::uses('AppController', 'Controller');

class EventsControllerTest extends ControllerTestCase {
	public $fixtures = array('app.event');
	
	// viewテスト
	public function testView(){
		$expected = array(
			'event' => array(
				'Event' => array(
					'id' => '1',
					'event_name' => 'First Event',
					'event_location' => 'First Event Location',
					'event_begin_date' => '2015-01-01',
					'event_begin_time' => '12:00:00',
					'event_end_date' => '2015-01-02',
					'event_end_time' => '12:00:00',
					'unique_str' => 'abcdefgh'
				)
			),
			'posters' => array()
		);
		$result = $this->testAction(
			'/events/view/abcdefgh',
			array(
				'return' => 'vars'
			)
		);
		$this->assertEquals($expected, $this->vars);
	}
	
}
?>