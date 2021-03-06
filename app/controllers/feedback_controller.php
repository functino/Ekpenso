<?php
class FeedbackController extends AppController {

	var $name = 'Feedback';
	var $helpers = array('Html', 'Form', 'Button');
	var $components = array('Auth');
	var $uses = array('Feedback');


	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set('_tab', 'contact');
	}
	
	

	function index() {
		
		// if no data is submitted
		if(empty($this->data))
		{
			//check if the user is logged in
		 	if($aUser = $this->Session->read('User'))
		 	{
		 		// pre-fill the fields with his data
				$this->data['Feedback']['name'] = $aUser['username'];
				$this->data['Feedback']['email'] = $aUser['email'];
			}
		}
		else
		{
			// if a user is logged in fill in his details
		 	if($aUser = $this->Session->read('User'))
		 	{
				$this->data['Feedback']['name'] = $aUser['username'];
				$this->data['Feedback']['email'] = $aUser['email'];
				$this->data['Feedback']['user_id'] = $aUser['id'];
			}
			
			if($this->Feedback->save($this->data['Feedback']))
			{
				$this->Session->setFlash(__('flash.Feedback.success', true));
				$this->redirect('/');	
			}
		}

	}
}