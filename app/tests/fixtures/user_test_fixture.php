<?php 
class UserTestFixture extends CakeTestFixture {
    var $name = 'UserTest';
	 
    var $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'email' => array('type' => 'string', 'length' => 255, 'null' => false),
        'password' => array('type' => 'string', 'length' => 32, 'null' => false),
        'username' => array('type' => 'string', 'length' => 255, 'null' => false),
        'activate_key' => array('type' => 'string', 'length' => 32, 'null' => false),
        'activated' => array('type' => 'string', 'length' => 20, 'null' => false, 'default'=>'no'),
        'password_key' => array('type' => 'string', 'length' => 32, 'null' => false),
        'cookie' => array('type' => 'string', 'length' => 32, 'null' => false),
        'created' => 'datetime',
        'updated' => 'datetime'
    );
    var $records = array(
	    array(
	        'id' => 1,
	        'email' => 'mail@example.com',
	        'password' => '1bc29b36f623ba82aaf6724fd3b16718', //md5("md5")
	        'username' => 'username',
	        'activate_key' => '1bc29b36f623ba82aaf6724fd3b16718',
	        'activated' => 'no',
	        'password_key' => '1bc29b36f623ba82aaf6724fd3b16718',
	        'cookie' => '1bc29b36f623ba82aaf6724fd3b16718',
	        'created' => '2008-04-01 15:00:00',
	        'updated' => '2008-04-01 15:00:00'
	    )
	); 
        
}
?>