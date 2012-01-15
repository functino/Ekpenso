<?php
class FeedbackFixture extends CakeTestFixture {
	var $name = 'Feedback';
	
	var $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'default' => '0', 'null' => false),
		'name' => 'text',
		'email' => array('type' => 'string', 'length' => 255, 'null' => false),
		'body' => 'text',
		'url' => array('type' => 'string', 'length' => 255, 'null' => false),
		'done' => array('type' => 'string', 'length' => 255, 'null' => false, 'default'=>'no'),
		'created' => 'datetime',
		'modified' => 'datetime',
	);
	
	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'name' => 'name',
			'email' => 'email',
			'body' => 'text',
			'url' => 'url',
			'done' => 'yes',
			'created' => '2007-03-18 10:39:23',
			'modified' => '2007-03-18 10:39:23',
		)
	);
}
?>