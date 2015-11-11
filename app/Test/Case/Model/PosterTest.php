<?php
App::uses('Poster', 'Model');
class PosterTest extends CakeTestCase {
	
	private $Poster = null;
	
	//SetUp
	public function setUp() {
		$this->Poster = new Poster;
		parent::setUp();
	}
	//TearDown
	public function tearDown() {
		unset($this->Poster);
		parent::tearDown();
	}
	
	// テストケース add(x, y)
	function testAdd() {
		$result = $this->Poster->add(1,2);
		$this->assertEquals(3, $result);
	}
	// テストケース multi(x, y)
	function testMulti() {
		$result = $this->Poster->multi(4,6);
		$this->assertEquals(24, $result);
	}
}
?>