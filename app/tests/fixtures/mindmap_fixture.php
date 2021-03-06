<?php 
/* SVN FILE: $Id: mindmap_fixture.php 12 2008-05-26 22:49:15Z ageier $ */
/* Mindmap Fixure generated on: 2008-05-27 00:05:04 : 1211839564*/

class MindmapFixture extends CakeTestFixture {
	var $name = 'Mindmap';
	
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'revision_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'lock_time' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'lock_user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'revision_id' => array('column' => 'revision_id', 'unique' => 0), 'lock_user_id' => array('column' => 'lock_user_id', 'unique' => 0))
			);
	var $records = array(array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'revision_id'  => 1,
			'lock_time'  => '2008-05-27 00:06:04',
			'lock_user_id'  => 1,
			'created'  => '2008-05-27 00:06:04',
			'modified'  => '2008-05-27 00:06:04'
			));
}
?>