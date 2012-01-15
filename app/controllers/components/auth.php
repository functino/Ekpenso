<?php
class AuthComponent extends Object
{
    var $Session = null;
    var $controller = true;
 
    function startup(&$controller)
    {
     	$this->controller = $controller;
	 	$this->Session = $controller->Session;
    }
 
    function check()
    {
        if(!$this->Session->check('User'))
		{
		 	$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->controller->redirect('/');
			exit();
		}
    }
}