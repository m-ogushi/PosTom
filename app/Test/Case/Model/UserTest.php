<?php
App::uses('User', 'Model');
class UserTest extends CakeTestCase {
	
	private $User = null;
	
	//SetUp
	public function setUp() {
		$this->User = new User;
		parent::setUp();
	}
	//TearDown
	public function tearDown() {
		unset($this->User);
		parent::tearDown();
	}
	
}
?>