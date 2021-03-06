<?php 
class AppController extends Controller {
	var $helpers = array('Html', 'Javascript', 'Form', 'Button');
	var $components = array('Auth', 'Cookie');
	
	function beforeFilter()
	{
		
		// set default tab for the views...
		$this->set('_tab', 'home');
		// set the default <title>
		$this->pageTitle = 'Ekpenso';

        // check for auto-login
        if(!$this->Session->check('User')) 
		{
            $this->auto_login();
        }  
	}
	
/**
 * Function to login a user via cookie
 */  	
    function auto_login() 
	{
		// read cookie-hash, relates to the cookie-column in user-table
        $cookie_hash = $this->Cookie->read('AutoLogin.hash'); 
        $cookie_id = $this->Cookie->read('AutoLogin.id'); // read user-id
        
        if($cookie_id AND $cookie_hash) 
		{
            if(!isset($this->User)) 
			{
                App::import('Model', 'User');
                $this->User = new User();
            }
            
            $this->User->contain();
            
            //find the user with the id and the cookie-hash
            $user = $this->User->findByCookieAndId($cookie_hash, $cookie_id);

            if(!$user) 
			{
                // not found. delete the cookie.
                $this->Cookie->del('AutoLogin');
            } 
			else 
			{
                $this->Session->write('User', $user['User']);
                // refresh auto login cookie
				$cookie = $this->User->generateHash(); //new random hash for security-reasons...
				$this->User->id = $cookie_id;
				$this->User->saveField('cookie', $cookie);
				
				$this->Cookie->write('AutoLogin.hash', $cookie, true, '4 weeks');
				$this->Cookie->write('AutoLogin.id', $cookie_id, true, '4 weeks');
            }
        }
    }
	
}
