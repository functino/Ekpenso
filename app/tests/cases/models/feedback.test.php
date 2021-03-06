<?php
App::import('Model','Feedback');

class FeedbackTest extends Feedback {
	var $name = 'FeedbackTest';
	var $useDbConfig = 'test_suite';
	var $useTable = null;
}


class FeedbackTestCase extends CakeTestCase {
	var $fixtures = array( 'feedback_test');
	
	function testTest() {	
		$this->FeedbackTest = new FeedbackTest();
		
		$result = $this->FeedbackTest->findById(1);
		$expected = array('FeedbackTest' => array(
				'id' => 1,
				'user_id' => 1,
				'name' => 'name',
				'email' => 'email',
				'body' => 'text',
				'url' => 'url',
				'done' => 'yes',
				'created' => '2007-03-18 10:39:23',
				'modified' => '2007-03-18 10:39:23'
			)
		);
		
		$this->assertEqual($result, $expected);
	}
	
}
?>