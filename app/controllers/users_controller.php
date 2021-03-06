<?php
class UsersController extends AppController {

	var $name = 'Users';
	
	// specify which helpers are loaded for this controller (see also app/app_controller.php)
	var $helpers = array('Html', 'Form');
	var $components = array('Email');
	
/**
 * Action to list the users groups
 */  	
	function my_groups()
	{
		//check if the user has a valid session, 
		//if not he gets redirected to '/' (see AuthComponent in app/controllers/components/auth.php)
		$this->Auth->check();
		$this->User->contain('Group.Admin', 'GroupAdmin', 'GroupInvitation.Group.Admin');
		$user = $this->User->findById($this->Session->read('User.id'));
		$this->set('user', $user);
	}

/**
 * Action to login a user
 */ 
	function login()
	{
		// POSTed data is automatically registered in $this->data
		if(!empty($this->data))
		{
			$user = $this->User->login($this->data['User']['email'], $this->data['User']['password']);
			if($user)
			{
				//with Session->write() we register data in the session
				$this->Session->write('User', $user['User']);
				
				//check if the user wants auto login.
				if(isset($this->data['User']['auto_login']))
				{
					$cookie = $this->User->generateHash();
					$this->User->id = $user['User']['id'];
					$this->User->saveField('cookie', $cookie);
					
					$this->Cookie->write('AutoLogin.hash', $cookie, true, '4 weeks');
					$this->Cookie->write('AutoLogin.id', $user['User']['id'], true, '4 weeks');
				}
				
				$this->redirect('/users/hello');
			}
		}
	}
	
/**
 * Action to logout a user
 */ 
	function logout()
	{
		$this->Session->del('User');
		$this->Cookie->del('AutoLogin');
		$this->redirect('/');
	}

/**
 * Start-page for logged-in users
 */ 	
	function hello()
	{
	 	$this->Auth->check();
	 	
		$this->User->Mindmap->contain();
		$mindmaps = $this->User->Mindmap->findAllByUserId($this->Session->read('User.id'), null, 'Mindmap.modified DESC', 5);
		$this->set('mindmaps', $mindmaps);
	}
	
	
/**
 * Display the profile of a user
 */ 
	function profile($username)
	{
		$this->Auth->check();
		
		// here we Tell the User-Model to load not only a User but also all his associated Mindmaps...
		$this->User->contain('Mindmap');
		
		// search in the users-table for a dataset with the username $username...
		$user = $this->User->findByUsername($username);
		
		//set $user for the View
		$this->set('user', $user);
	}


/**
 * Action to sign up a user
 */ 
	function register()
	{
		$this->layout = 'register';
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data))
			{
			 	$id = $this->User->getLastInsertId();
			 	$this->User->contain();
			 	$user = $this->User->findById($id);
			 	
			 	
				$this->Email->delivery = Configure::read('Email.delivery');
		        $this->Email->to = $user['User']['email'];
		        $this->Email->subject = __('Email.activation', true);
		        $this->Email->from = Configure::read('Email.from');
		        $this->Email->template = Configure::read('Config.language').'/activation';
				$this->Email->smtpOptions = Configure::read('Email.smtpOptions');
		        //Set view variables as normal
		        $this->set('name', $user['User']['username']);
		        $this->set('key', $user['User']['activate_key']);
		        $this->set('url', Router::url('/users/activate/'.$user['User']['activate_key']));
		        $this->Email->send();

		 
		 		//login the user
		 		$this->Session->setFlash(__('flash.User.register', true));
				$this->Session->write('User', $user['User']);
				$this->redirect('/users/hello');
			} else {
				$this->Session->setFlash(__('flash.User.register.failed', true), 'flash_error');
			}
		}		
	}


/**
 * Action to activate an account
 * The link to this action is sent via mail
 */  
	function activate($key = null)
	{
		if(!empty($this->data['User']['activate_key']))
		{
			$key = $this->data['User']['activate_key'];
		}
		
		if(!empty($key))
		{
			if($user_id = $this->User->activate($key))
			{
				$this->Session->setFlash(__('flash.User.activate', true));
				
				//user is not logged in yet
				if(!$this->Session->check('User'))
				{
				 	//log him in
				 	$this->User->contain();
					$user = $this->User->findById($user_id);
					$this->Session->write('User', $user['User']);
				}
				$this->redirect('/users/hello');
			}
			else
			{
				$this->Session->setFlash(__('flash.User.activate.failed', true), 'flash_error');
			}
		}
	}

/**
 * Action to edit the password
 */ 
	function edit_password()
	{
		$this->Auth->check();
		
		if(!empty($this->data))
		{
			$this->data['User']['id'] = $this->Session->read('User');
			
			if($this->data['User']['password']!=$this->data['User']['password2'])
			{
				$this->User->invalidate('password__confirm');
				$this->Session->setFlash(__('error', true));
			}
			else
			{
				$aSave = array();
				$aSave['User']['id']= $this->Session->read('User.id');
				$aSave['User']['password']= $this->data['User']['password'];

				if($this->User->save($aSave))
				{
					$this->Session->setFlash(__('saved', true));
				}
				else
				{
					$this->Session->setFlash(__('error', true));
				}				
			}
		}
	}

	function edit()
	{
		
	}


/**
 * Request a new password
 */ 
	function request_password()
	{
		if(!empty($this->data))
		{
			$user = $this->User->findByEmail($this->data['User']['email']);
			if($user)
			{
				$time = strtotime($user['User']['modified']);
				if(time() - $time < 60 * 60 AND false)
				{
				 	$this->Session->setFlash(__('flash.User.request_password.wait', true));
				}
				else
				{
					$this->Session->setFlash(__('flash.User.request_password.success', true));
					
					$this->User->id = $user['User']['id'];
					$password_key = $this->User->generateHash();
					$this->User->saveField('password_key', $password_key);
					$this->User->saveField('modified', date('Y-m-d H:i:s'));	


					$this->Email->smtpOptions = Configure::read('Email.smtpOptions');
					$this->Email->delivery = Configure::read('Email.delivery');
					
			        $this->Email->to = $this->data['User']['email'];
			        $this->Email->subject = __('Email.password_request', true);
			        $this->Email->from = Configure::read('Email.from');
			        $this->Email->template = Configure::read('Config.language').'/password';
			        $this->set('username', $user['User']['username']);
			        $this->set('key', $password_key);
			        //@TODO url has to be language-specific
			        $this->set('url', Router::url('http://ekepnso.com/users/activate_password/'.$password_key));
			        $this->Email->send();
			        //pr($this->Session->read('Message.email')); 
				}
			}
			else
			{
				$this->Session->setFlash(__('flash.User.request_password.failed', true), 'flash_error');
			}
		}		
	}


/**
 * Activate a requestes password
 */ 
	function activate_password($password_key)
	{
	 	if($this->Session->check('User') or empty($password_key))
	 	{
			$this->redirect('/');
		}
		if($password = $this->User->activatePassword($password_key))
		{
			$this->set('password', $password);
		}
		else
		{
			$this->Session->setFlash('flash.User.activate_password.fail', 'flash_error');
			$this->set('password', false);
		}
	}
	
	
	
	
/**
 * Called via ajax to check if a username is free and valid
 */ 	
	function checkUsername($name)
	{
	 	$this->autoRender = false;
	 	$this->layout = 'empty';
		$user = $this->User->findCount('username = "'. mysql_real_escape_string($name).'"');
		
		if($user)
		{
			echo '<span style="color:red;">'.__('error.User.username.taken', true).'</span>';
		}
		elseif(!preg_match('#^([a-z0-9_-]+)$#i', $name))
		{
			echo '<span style="color:red;">'.__('error.User.username.valid', true).'</span>';			
		}
		else
		{
			echo '<span style="color:green;">'.__('User.name_ok', true).'</span>';
		}
	}
	
/**
 * Called via ajax, checks if the given mail is free and valid
 */ 	
	function checkEmail($mail)
	{
	 	$this->autoRender = false;
	 	$this->layout = 'empty';
		$user = $this->User->findCount('email = "'. mysql_real_escape_string($mail).'"');
		if($user)
		{
			echo '<span style="color:red;">'.__('error.User.email.taken', true).'</span>';
		}
	}
	
	
}
?>