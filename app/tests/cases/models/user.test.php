<?php 
App::import('Model', 'User');

//class User extends User {
//	var $name = 'User';
//	var $useDbConfig = 'test_suite';
//}

class UserCase extends CakeTestCase {
    //var $fixtures = array( 'user_test' );

/**
 * Checks if findById works as expected
 */ 
    function testFindById() {
        $this->User = new User();
        
        $this->User->contain();
        $result = $this->User->findById(1, 'email');
        
        $expected = array('User' => array( 'email' => 'mail@example.com' ) );
        
        $this->assertEqual($result, $expected);
    }
    
    
 /**
 * Checks findById with missing id
 */   
    function testFindByIdWithMissingId() {
        $this->User =& new User();
        
        $this->User->contain();
        $result = $this->User->findById(99999999, 'username');
        $this->assertFalse($result);
    }


	############ test-cases for activation ################
	
/**
 * Checks the User::activate()-method
 * with a wrong key
 */ 
    function testActivateFail() {
        $this->User =& new User();
        
        //should fail, since no such key is in the database
        $result = $this->User->activate('wrongkey');
        $this->assertFalse($result);
    }

/**
 * Checks the User::activate()-method
 * with a valid key
 */
    function testActivateSuccess() {
        $this->User =& new User();
    
    	//check if the user is not activated yet
    	$activated = $this->User->field('activated', array('id'=>'1'));
    	$this->assertEqual('no', $activated);
    
    	// should activate the first user.
        $result = $this->User->activate('1bc29b36f623ba82aaf6724fd3b16718');
        $this->assertTrue($result);
 		
 		//check if the activation really worked
    	$activated = $this->User->field('activated', array('id'=>'1'));
    	$this->assertEqual('yes', $activated);
    	
    	
    	
    	//test done, set data back to original values...
    	$this->User->id = 1;
    	$this->User->saveField('activated', 'no');
    }
    

    ################# Test-cases for the login ############### 
/**
 * Checks the User::login()-method
 * with invalid combinations of email and password
 */   
    function testLoginFail()
    {
    	$this->User = new User();
    	//check with wrong email and wrong pass
		$this->assertFalse( $this->User->login('wrongemail', 'wrongpass') );
		
		//check with valid password but wrong email
		$this->assertFalse( $this->User->login('wrongemail', 'password') );
		
		//check with valid email but wrong pass
		$this->assertFalse( $this->User->login('mail@example.com', 'wrongpass') );
		
		//check with valid email but no password
		$this->assertFalse( $this->User->login('mail@example.com', '') );
		
		//check with empty user-data
		$this->assertFalse( $this->User->login('', '') );
	}
	

/**
 * Checks the User::login()-method
 * with valid login-data
 */  	
	function testLoginSuccess()
	{
    	$state = $this->User->login('mail@example.com', 'password');
		$this->assertTrue($state);
	}
	
	
###################### test-cases for passwort activation ######################

/**
 * Checks the User::activate_password()-method
 * with a wrong key and check the return type and if the password is still the same
 */ 
    function testActivatePasswordFail() {
        $this->User = new User();
        
        //get the current password-hash
    	$expected = $this->User->field('password', array('id'=>'1'));
    	
    	//activate with wrong key - should fail
        $result = $this->User->activatePassword('wrongkey');
        $this->assertFalse($result);
        
        //check if the password in the database has changed
    	$result = $this->User->field('password', array('id'=>'1'));
    	$this->assertEqual($result, $expected);
    }
    
/**
 * Checks the User::activate_password()-method
 * with the right key
 */ 
    function testActivatePasswordSuccess() {
        $this->User = new User();
     	
		$expected = $this->User->field('password', array('id'=>'1'));	
    	
    	// should return the new password
        $password = $this->User->activatePassword('1bc29b36f623ba82aaf6724fd3b16718');
        $this->assertTrue($password);
        
        //checkk if the password has changed
		$result = $this->User->field('password', array('id'=>'1'));	
    	$this->assertNotEqual($result, $expected);
    	
    	//check if the returned password is the same as in the database
    	$this->assertEqual(md5($password), $result);
    	
    	
    	
    	//test done set data to the original values
    	$this->User->id=1;
    	$this->User->saveField('password', $expected);
    	$this->User->saveField('password_key', '1bc29b36f623ba82aaf6724fd3b16718');
    }
    
    
/**
 * tests if the password-generation works
  */ 
   function testGeneratePassword() {
        $this->User = new User();
  		$pass = $this->User->generatePassword();    	
    	$this->assertNotNull($pass);
    	$this->assertPattern('#[a-zA-Z0-9]{6,15}#', $pass, 'Password is not between 6 and 15 chars long');
    }
    
    
    
/**
 * Checks if registration validates data correctly
 */ 
    function testRegisterValidationFail() {
        $this->User = new User();
        
   
        //existing username
        $save = array();
        $save['User']['username'] = 'username';
        $save['User']['password'] = 'pass';
        $save['User']['email'] = '_email@example.com';
        $save['User']['agb'] = 1;
        $result = $this->User->save($save);
        $this->assertFalse($result);
        
        //check if the expected fields are invalidated
		$fields = $this->_getInvalidFields($this->User);
		$this->assertTrue(in_array('username', $fields));
		
		
        //existing email
        $save = array();
        $save['User']['username'] = 'usernamenotexists';
        $save['User']['password'] = 'pass';
        $save['User']['email'] = 'mail@example.com';
        $save['User']['agb'] = 1;
        $result = $this->User->save($save);
        $this->assertFalse($result);
        
        //check if the expected fields are invalidated
		$fields = $this->_getInvalidFields($this->User);
		$this->assertTrue(in_array('username', $fields));
   
        
        //invalid username, invalid email, valid pass
        $save = array();
        $save['User']['username'] = '&%§"jljl';
        $save['User']['password'] = 'pass';
        $save['User']['email'] = 'email';
        $save['User']['agb'] = 1;
        $result = $this->User->save($save);
        $this->assertFalse($result);
        
        //check if the expected fields are invalidated
		$fields = $this->_getInvalidFields($this->User);
		$this->assertTrue(in_array('username', $fields) && in_array('email', $fields));


		//valid username, valid email, invalid pass
        $save = array();
        $save['User']['username'] = 'valdiusername';
        $save['User']['password'] = 't'; //too short
        $save['User']['email'] = 'validemail@example.com';
        $save['User']['agb'] = 1;
        $result = $this->User->save($save);
        $this->assertFalse($result);
        
		$fields = $this->_getInvalidFields($this->User);
		$this->assertTrue(in_array('password', $fields));
		
		
		//invalid email
		$save = array();
        $save['User']['username'] = 'valdiusername';
        $save['User']['password'] = 'validpass'; 
        $save['User']['agb'] = 1;
        $save['User']['email'] = 'invalid'; 
        $result = $this->User->save($save);
        $this->assertFalse($result);
        
		$fields = $this->_getInvalidFields($this->User);
		$this->assertTrue(in_array('email', $fields));
    } 
    
	function testRegisterValidationSucess()
	{
		$save = array();
        $save['User']['username'] = 'valid';
        $save['User']['password'] = 'validpass'; 
        $save['User']['email'] = 'validemail@example.com';
        $save['User']['agb'] = 1;
        $this->User->create();
        $result = $this->User->save($save);
        $this->assertTrue($result);
        
		$fields = $this->_getInvalidFields($this->User);
		$this->assertEqual($fields, array());
		
		$this->User->contain();
		$result = $this->User->findByUsername('valid', 'username, password, email, activated');
		
		$expected = array('User' => array(
				'username' => 'valid',
				'password' => md5('validpass'),
				'email' => 'validemail@example.com',
				'activated' =>'no'
			)
		);
		$this->assertEqual($result, $expected);
		
		//check if a 32-chars key is created...
		$key = $this->User->field('activate_key', array('username'=>'valid'));
		$this->assertTrue(32 == strlen($key));
		
		
		
		//test done delte the user...
		$this->User->del($this->User->id);
		
	}
	
	
    
    function _getInvalidFields($model)
    {
        $invalidFields = array();
        foreach($model->validationErrors as $field=>$msg)
        {
			$invalidFields[] = $field;
		}
		return $invalidFields;
	}
    

}
?> 