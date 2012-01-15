<?php
class TagsController extends AppController {

	var $name = 'Tags';
	var $helpers = array('Html', 'Form');

/**
 * Action to delete a tag
 */ 
	function delete($id)
	{
		$this->Auth->check();
		
		$this->Tag->contain();
		$tag = $this->Tag->findById($id, 'user_id');
		if($tag['Tag']['user_id'] != $this->Session->read('User.id'))
		{
			$this->Session->setFlash(__('no_auth', true), 'flash_error');
			$this->redirect('/');
			return;
		}
		
		
		$this->Tag->del($id, false);
		
		$this->Session->setFlash(__('flash.Tag.delete', true));
		$this->redirect('/mindmaps/tags');
	}
}
?>