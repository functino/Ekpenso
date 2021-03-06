<?php 
class MindmapTestFixture extends CakeTestFixture {
	
    var $name = 'MindmapTest';
    
    var $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'name' => array('type' => 'string', 'length' => 255, 'null' => false),
        'user_id' => array('type' => 'integer', 'null' => false),
        'revision_id' => array('type' => 'integer', 'null' => false),
        'public' => array('type' => 'string', 'length' => 5, 'null' => false, 'default'=>'no'),
        'lock_time' => 'datetime',
        'lock_user_id' => array('type' => 'integer', 'null' => false),
        'created' => 'datetime',
        'modified' => 'datetime'
    );
    
    var $records = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'name' => array('type' => 'string', 'length' => 255, 'null' => false),
        'user_id' => array('type' => 'integer', 'null' => false),
        'revision_id' => array('type' => 'integer', 'null' => false),
        'public' => array('type' => 'string', 'length' => 5, 'null' => false, 'default'=>'no'),
        'lock_time' => 'datetime',
        'lock_user_id' => array('type' => 'integer', 'null' => false),
        'created' => 'datetime',
        'modified' => 'datetime'		        
	);
  
}
?>