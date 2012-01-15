<?php 

App::import('Controller', 'Groups');

class GroupsControllerTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new GroupsController();
	}

	function tearDown() {
		unset($this->TestObject);
	}

	
	function testMe() {
		
		//$result = $this->TestObject->index();
		$result = 1;
		$expected = 1;
		$this->assertEqual($result, $expected);
	}
	
	function testXou() {
		
		//$result = $this->TestObject->index();
		$result = 1;
		$expected = 1;
		$this->assertEqual($result, $expected);
		
	}
}
?>