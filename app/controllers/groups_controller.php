<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');


/**
 * Invite a user to a group
 */ 
	function invite($group_id)
	{
		$this->Auth->check();
		
		$this->Group->contain();
		$group = $this->Group->findById($group_id);
		if($group['Group']['user_id']!=$this->Session->read('User.id'))
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->redirect('/');
		}
		else
		{
			$this->Session->setFlash('Jup');
			if(isset($this->data['GroupInvitation']['username']))
			{
				$username = $this->data['GroupInvitation']['username'];
				$this->Group->User->contain();
				$user = $this->Group->User->findByUsername($username);
				if(!$user)
				{
					$this->Session->setFlash(__('flash.Group.invite.not_found', true), 'flash_error');
				}
				else
				{
					$save = array();
					$save['user_id'] = $user['User']['id'];
					$save['group_id'] = $group_id;
					$save['message'] = $this->data['GroupInvitation']['message'];
					$this->Group->GroupInvitation->save($save);
					$this->Session->setFlash(sprintf(__('flash.Group.invite.success', true), h($user['User']['username'])));
				}
			}
			$this->redirect('/groups/edit/'.$group_id);	
		}	
	}
	
/**
 * Add a mindmap to a group
 */ 
	function add_mindmap($mindmap_id)
	{
		$this->Auth->check();
		
		//@TODO check if the group exists and if the user has the right to add a mindmap...
		
		if(isset($this->data['Group']['id']))
		{
			if($this->Group->habtmAdd('Mindmap', $this->data['Group']['id'], $mindmap_id))
			{
				$this->Session->setFlash(__('flash.Group.add_mindmap', true));	
			}
			
		}
		$this->redirect('/mindmaps/edit/'.$mindmap_id);
	}


/**
 * Accept an invitation
 */ 	
	function accept_invitation($invitation_id)
	{
		$this->Auth->check();
		$ok = $this->Group->GroupInvitation->accept($invitation_id, $this->Session->read('User.id'));
		
		//accept() should return true - otherwise the user entered an invalid id...
		if($ok)
		{
			$this->Session->setFlash(__('flash.Group.accept_invitation', true));
		}	
		$this->redirect('/users/my_groups');
	}

/**
 * Delete an invitation
 */ 	
	function delete_invitation($invitation_id)
	{
		$this->Auth->check();
		$this->Group->GroupInvitation->contain();
		$in = $this->Group->GroupInvitation->findByid($invitation_id);
		
		if($in['GroupInvitation']['user_id'] == $this->Session->read('User.id'))
		{
			$this->Group->GroupInvitation->del($invitation_id);
			$this->Session->setFlash(__('flash.Group.delete_invitation', true));
		}
		
		$this->redirect('/users/my_groups');
	}

/**
 * Leave a group
 */ 	
	function leave($id)
	{
		$this->Auth->check();
		$return = $this->Group->leave($id, $this->Session->read('User.id'));
		
		if($return === true)
		{
			$this->Session->setFlash(__('flash.Group.leave', true));				
		}
		else
		{
			$this->Session->setFlash(__($return));
		}
		$this->redirect('/users/my_groups');
	}

	function view($id = null) {
		$this->Auth->check();
		
		$this->Group->contain('User', 'Admin', 'Mindmap.User');
		$group = $this->Group->findById($id);
		$this->set('group', $group);
	}


/**
 * create a new group
 */  
	function add() 
	{
		$this->Auth->check();
		
		if(!empty($this->data)) 
		{
			$this->Group->create();
			
			$save = array();
			$save['Group']['name'] = $this->data['Group']['name'];
			$save['Group']['user_id'] = $this->Session->read('User.id');
			$save['User'][] = $this->Session->read('User.id'); //add the Admin as first user...
			if($this->Group->save($save)) 
			{
				$this->Session->setFlash(__('flash.Group.add', true));
				$this->redirect('/users/my_groups');
			} 
			else 
			{
				$this->Session->setFlash(__('flash.Group.add.failed', true), 'flash_error');
			}
		}
	}

/**
 * Edit group-settings
 */ 
	function edit($id) 
	{
		$this->Auth->check();
		$this->Group->contain('User', 'Mindmap');
		$group = $this->Group->findById($id);
		if($group['Group']['user_id'] == $this->Session->read('User.id'))
		{
			if(!empty($this->data))
			{
				if($this->Group->save($this->data, array('name')))
				{
					$this->Session->setFlash(__('flash.saved', true));
				}
				else
				{
					$this->Session->setFlash(__('flash.error', true), 'flash_error');
				}
			}
			else
			{
				$this->data = $group;
			}
			
			$this->set('group', $group);		
		}
		else
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->redirect('/');
		}
	}


/**
 * Remove a mindmap from a group
 */ 	
	function remove_mindmap($group_id, $mindmap_id)
	{
		$this->Auth->check();
		$this->Group->contain();
		$group = $this->Group->findById($group_id);
		
		$auth = false;
		$redirect = '/';
		if($group['Group']['user_id'] == $this->Session->read('User.id'))
		{
			$auth = true;
			$redirect = '/groups/edit/'.$group_id;
		}
		else
		{
			$this->Group->Mindmap->contain();
			$mindmap = $this->Group->Mindmap->findById($mindmap_id);
			if($mindmap['Mindmap']['user_id'] == $this->Session->read('User.id'))
			{
				$auth = true;
				$redirect = '/mindmaps/edit/'.$mindmap_id;
			}
		}
		
		if($auth == true)
		{
			$this->Group->habtmDelete('Mindmap', $group_id, $mindmap_id);
			$this->Session->setFlash(__('flash.Group.remove_mindmap', true));
		}
		else
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
		}
		$this->redirect($redirect);
	}


/**
 * Remove a user from a group
 */ 	
	function remove_user($group_id, $user_id)
	{
		$this->Auth->check();
		$this->Group->contain();
		$group = $this->Group->findById($group_id);
		if(!empty($group) && $group['Group']['user_id'] == $this->Session->read('User.id'))
		{
			if($user_id != $this->Session->read('User.id'))
			{
				$this->Group->habtmDelete('User', $group_id, $user_id);
				$this->Session->setFlash(__('flash.Group.remove_user', true));		
			}
			else
			{
				$this->Session->setFlash(__('flash.Group.remove_user.admin', true), 'flash_error');
			}
			$this->redirect('/groups/edit/'.$group_id);		
		}
		else
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->redirect('/');
		}

	}
	

/**
 * Delete a group
 */ 
	function delete($id) 
	{
		$id = (int) $id;
		$this->Auth->check();
		$this->Group->contain();
		$group = $this->Group->findById($id);
		if($group['Group']['user_id'] == $this->Session->read('User.id'))
		{
			$this->Group->del($id);
			$this->Session->setFlash(__('flash.Group.delete', true));
		}
		else
		{
			$this->Session->setFlash(__('flash.Group.delete.not_found', true), 'flash_error');
		}
		
		$this->redirect('/users/my_groups');
	}
}
