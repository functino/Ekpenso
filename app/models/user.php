<?php
class User extends AppModel {

	var $name = 'User';
	// in $validate we can create rules which cake validates evrytime we call the save()-Function
	var $validate = array(
	        'username' => array( // this are the rules for the field username
	            'taken' => array(
								'rule'=>array('validateUnique', array('field'=>'username')), //here we use a custom function see 
								'message'=>'error.User.username.taken'), // this is the error-message
	            'required' => array(
								'rule'=>VALID_NOT_EMPTY, 
								'message'=>'error.User.username.required'),
	            'length' => array(
								'rule'=> array('between', 3, 20), 
								'message'=>'error.User.username.length'),
	            'valid' => array(
								'rule'=>'#^[a-z0-9_-]*$#i', 
								'message'=>'error.User.username.valid'),
	        ),
	        'email' => array(
	        	'valid' => array(
							'rule'=>VALID_EMAIL, 
							'message'=>'error.User.email.valid'),
	            'taken' => array(
							'rule'=> array('validateUnique', array('field'=>'email')), 
							'message'=>'error.User.email.taken'),
			),
			'password' => array(
				'length' => array(
							'rule' => array('minLength', 3), 
							'message' =>'error.User.password.length'),
			),
	    ); 

 	public function beforeSave()
 	{
 	 	//if a not-yet hashed password is given - hash it
		if(isset($this->data[$this->name]['password']) && strlen($this->data[$this->name]['password'])!=32)
		{
			$this->data[$this->name]['password'] = md5($this->data[$this->name]['password']);
		}

		
		//if it is a new user give him an (activate-)key
		if(!isset($this->data[$this->name]['id']))
		{
	        $this->data[$this->name]['activate_key'] = $this->generateHash();
		}
		return true;
	}
	
	public function beforeValidate()
	{
		// and check for agb-acceptance
		if(!isset($this->data[$this->name]['id']))
		{
		    if(empty($this->data[$this->name]['agb']))
	        {
				$this->invalidate('agb');
			}
		}		
		return true;
	}


	var $hasMany = array(
			'Mindmap',
			'GroupAdmin' => array('className' => 'Group',
								'foreignKey' => 'user_id'),
			'GroupInvitation',
			'Openid',
	);

	var $hasAndBelongsToMany = array(
			'Group'
	);



/**
 * Activates a user if a valid key is given
 * @param string $key the key of a user - relates to the field activate_key in the db
 * @return mixed Returns false on fail and the id of the activated user on success
 */    	
	function activate($key)
	{
	 	$this->contain();
	 	$user = $this->findByActivateKey($key, 'id');
	 	
	 	if(!$user)
	 	{
			return false;
		}
		else
		{	
		 	$this->id = $user[$this->name]['id'];
			$this->saveField('activated', 'yes');	
			return $this->id;
		}
	}

/**
 * Checks if a given combination of an email and a password are valid and returns a user if so
 * it also invalidates a pseudo-field "login" 
 * @param string $email The user's email
 * @param string $password The user's password (unhashed)
 * @return mixed The array returned by the find-method on succes, false otherwise   
 */ 
	function login($email, $password)
	{
		$password = md5($password);
		$this->contain();
		$user = $this->find('first', array('conditions' => 
												array(
													'email' => $email, 
													'password' => $password ) ) );
		if(!$user)
		{
			// with invalidate() we can invalidate a form-field (normally this happens automatically...)
			$this->invalidate('login');
			return false;
		}
		return $user;
	}



/**
 * Checks if a given key for password activation is valid
 * creates, saves and returns the new password if the key is valid
 * otherwise it returns false  
 * @param string $key the password_key
 * @return mixed the new generated password if the key is valid, false otherwise   
 */ 	
	function activatePassword($key)
	{
		$this->contain();
		$user = $this->findByPasswordKey($key, 'id');
		if($user == false)
		{
			return false;
		}
		
		$this->id = $user[$this->name]['id'];
		$this->saveField('password_key', '');
		$password = $this->generatePassword();
		$this->saveField('password', md5($password));
		$this->saveField('modified', date('Y-m-d H:i:s'));
		
		return $password;
	}
	

/** 
 * Creates a new random password
 * @return String the new password
 */
	function generatePassword()
	{
		$length = rand(7, 12);
		$start = rand(0, 32-$length);
		$randomHash = $this->generateHash();
		return substr($randomHash, $start, $length);
	}  
	
/** 
 * Creates a new random string with 32-characters
 * @return String the new password
 */
	function generateHash()
	{
		$randomHash = md5(uniqid().microtime());
		return $randomHash;
	}  
	
	
/**
 * Finds a User with the given Openid
 */
	function findOpenid($openid)
	{
		$this->Openid->contain('User');
		$user = $this->Openid->findByOpenidUrl($openid);
		if(!$user)
		{
			return false;
		}
		else
		{
			
			return array('User' => $user['User']);
		}
	} 
	
/**
 * Attachs an openid to a user
 * @param int $user_id the users id
 * @param string $openid_url the users openid   
 * @return boolean 
 */
	function attachOpenid($user_id, $openid_url)
	{
		$arr = array();
		$arr['user_id'] = $user_id;
		$arr['openid_url'] = $openid_url;
		
		return $this->Openid->save($arr);
	} 
	
/**
 * Detachs an openid from a user
 * @param int $user_id the users id
 * @param string $openid the users openid 
 * @return boolean true if deleted, false if an error occured or the given openid does not belong to the given user 
 */
	function detachOpenid($user_id, $openid_id)
	{
		$this->Openid->id = $openid_id;
		$id = $this->Openid->field('user_id');
		if($id == $user_id)
		{
			return $this->Openid->del($openid_id);
		}
		else
		{
			return false;
		}
	}
}
?>