<?php
App::uses('Event', 'Model');
class EventTest extends CakeTestCase {
	
	private $Event = null;
	
	//SetUp
	public function setUp() {
		$this->Event = new Event;
		parent::setUp();
	}
	//TearDown
	public function tearDown() {
		unset($this->Event);
		parent::tearDown();
	}
	
	// テストケース dayDiff(x, y)
	function testDayDiff() {
		$_SESSION['event_id'] = 1;
		$result = $this->Event->dayDiff();
		$this->assertEquals(1, $result);
	}
}
?>