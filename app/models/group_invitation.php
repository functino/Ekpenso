<?php
class GroupInvitation extends AppModel {

	var $name = 'GroupInvitation';
	
	var $belongsTo = array(
			'Group' =>
				array('className' => 'Group',
						'foreignKey' => 'group_id',
				),
			'User' =>
				array('className' => 'User',
						'foreignKey' => 'user_id',
				),
	);
	
	
	
/**
 * Accept an invitation to a group
 * 	function returns true if the given user could be added to the group...
 * @param int $invigation_id the id of the invitation
 * @param int $user_id the user
 * @return boolean returns true on success
 */    	
	function accept($invitation_id, $user_id)
	{
		$this->contain();
		$invitation = $this->findByid($invitation_id);
		
		//check if this invitation is a for the given user_id...
		if($invitation[$this->name]['user_id'] == $user_id)
		{
			//add the user to the group
			$this->Group->habtmAdd('User', $invitation[$this->name]['group_id'], $invitation[$this->name]['user_id']);
			//delete the invitation
			$this->del($invitation_id);
			return true;
		}
		return false;
	}
}
