<?php
class OpenidController extends AppController {

	var $name = 'Openid';
	
	// specify which helpers are loaded for this controller (see also app/app_controller.php)
	var $helpers = array('Html', 'Form');
	var $components = array('Email', 'Openid');
	var $uses = array('User');
	
/**
 * Action to login via openid or to add an openid to an exisiting profile or to register 
 */ 
    function login() {
    	//@TODO: url has to be relative and/or should be set in bootstrap
		$returnTo = 'http://'.env('HTTP_HOST').'/index.php?url=openid/complete';
        if (!empty($this->data)) {
        	$this->Session->write('Openid.url', $this->data['OpenidUrl']['openid']);
            try {
            	//check if the openid is attached to a user...
            	$user = $this->User->findOpenId($this->data['OpenidUrl']['openid']);
            	if($user) // openid is attached to a user -> wants to login
            	{
					$this->Openid->authenticate($this->data['OpenidUrl']['openid'], $returnTo, 'http://'.$_SERVER['SERVER_NAME']);	
				}
				else // openid not yet attached to a user -> wants to signup
				{
					$this->Openid->authenticate($this->data['OpenidUrl']['openid'], $returnTo, 'http://'.$_SERVER['SERVER_NAME'], array('email'), array('nickname'));	
				}
            } catch (InvalidArgumentException $e) {
                $this->set('message', 'Invalid OpenID');
            } catch (Exception $e) {
                $this->set('message', $e->getMessage());
            }
        } 
    } 
    
/**
 * This action get's called by the Openid-Provider after successfully authentication
 */ 
    function complete()
    {
    	$returnTo = 'http://'.env('HTTP_HOST').'/index.php?url=openid/complete';
        $response = $this->Openid->getResponse($returnTo);
        if ($response->status == Auth_OpenID_CANCEL) {
            $this->set('message', 'Verification cancelled');
        } elseif ($response->status == Auth_OpenID_FAILURE) {
            $this->set('message', 'OpenID verification failed: '.$response->message);
        } elseif ($response->status == Auth_OpenID_SUCCESS) {
        	$openid = $response->identity_url;
        	$this->Session->write('Openid.verified', $openid);
            
            
            $user = $this->User->findOpenId($openid);
            // given openid is attached to a user -> user wants to login
            if($user)
            {
					$this->Session->write('User', $user['User']);
					$this->redirect('/users/hello');
			} 
			else // given openid is not yet attached to a user -> user wants to sign up
			{
            	//check if the user is already logged in -> wants to attach an openid to his account
            	if($this->Session->check('User'))
            	{
					$this->redirect('/openid/attach');
				}
				else
				{
					$sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
					$sreg = $sregResponse->contents();
					$this->Session->write('Openid.data', $sreg);
					$this->redirect('/openid/register');
				}				
			}
            exit;
        }
	}


/**
 * Attachs an openid to a user
 */ 
	function attach()
	{
		$this->Auth->check();
		
		if($this->Session->check('Openid.verified'))
		{
			if($this->User->attachOpenid($this->Session->read('User.id'), $this->Session->read('Openid.verified')))
			{
				$this->Session->setFlash(__('flash.Openid.attached', true));
			}
		}
		$this->redirect('/openid/manage');
	}

/**
 * Deletes an openid from a user
 */  	
	function detach($id)
	{
		$this->Auth->check();
		$this->User->Openid->id = (int) $id;
		
		if($this->User->detachOpenid($this->Session->read('User.id'), $id))
		{
			$this->Session->setFlash(__('flash.Openid.detached', true));
			$this->redirect('/openid/manage');			
		}
		else
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->redirect('/users/hello');
		}
	}

/**
 * Action to list all attached openids to a user
 * and give him the possibility to manage it 
 */ 
	function manage()
	{
		$this->Auth->check();
		$this->User->contain('Openid');
		$user = $this->User->findById($this->Session->read('User.id'));
		$this->set('user', $user);
	}


/**
 * Register-Action via Openid
 * @TODO keep it DRY - this code is duplicated in UsersController::register() 
 */ 	
	function register()
	{
		$this->layout = 'register';
		//check if the openid is verified - if not the user can not register himself via openid...
		if(!$this->Session->check('Openid.verified'))
		{
			$this->Session->setFlash(__('no_auth', true), 'flash_error');
			$this->redirect('/');
		}
		if(empty($this->data))
		{
			$data = $this->Session->read('Openid.data');
			if(isset($data['nickname']))
			{
				$this->data['User']['username'] = $data['nickname'];
			}
			if(isset($data['email']))
			{
				$this->data['User']['email'] = $data['email'];
			}
		}
		if (!empty($this->data)) 
		{
			//create a dummy password
			$this->data['User']['password'] = $this->User->generatePassword();
			$this->User->create();
			if ($this->User->save($this->data))
			{
			 	$id = $this->User->getLastInsertId();
			 	$this->User->contain();
			 	$user = $this->User->findById($id);
				$this->User->attachOpenid($id, $this->Session->read('Openid.verified'));	
			 	
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
}	
?>