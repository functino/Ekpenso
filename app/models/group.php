<?php
class Group extends AppModel {

	var $name = 'Group';
	var $validate = array(
	        'name' => array(
	            'valid' => array(
								'rule'=>'#[a-z0-9_-]{1,}#i', // there has to be at least one character... 
								'message'=>'error.Group.name.valid'),
	        )
	    ); 	
	
	var $belongsTo = array(
			'Admin' =>
				array('className' => 'User',
						'foreignKey' => 'user_id',
				),
	);
	
	var $hasAndBelongsToMany = array(
			'Mindmap',
			'User'
			);
			
			
	var $hasMany = array(
			'GroupInvitation' => array('className' => 'GroupInvitation',
								'foreignKey' => 'group_id',
								'dependent' => true,
			),
	);
	
	
/**
 * Delete a user from a group
 * 	function returns true if the given user could be removed from the group...
 * @param int $group_id the id of the group
 * @param int $user_id the user
 * @return mixed returns true on success, or an error-msg if something went wrong
 */   
	function leave($group_id, $user_id)
	{
		$this->contain();
		$group = $this->findById($group_id);
		
		//check if the group exists
		if($group)
		{
			//check if the given user is the admin of this group
			if($group[$this->name]['user_id'] != $user_id)
			{
				$this->habtmDelete('User', $group_id, $user_id);
				return true;				
			}
			else
			{
				return 'flash.Group.leave.admin';
			}
		}
		else
		{
			return 'flash.Group.leave.not_found';
		}
	}
	
}
