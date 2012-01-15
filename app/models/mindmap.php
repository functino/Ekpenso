<?php
class Mindmap extends AppModel {

	var $name = 'Mindmap';
	var $validate = array(
	        'name' => array(
	            'valid' => array(
								'rule'=>'#[a-z0-9_-]{1,}#i', // there has to be at least one character... 
								'message'=>'error.Mindmap.name.valid'),
	        )
	    ); 	
	
	
	var $belongsTo = array(
			'User',
			'Data' =>
				array('className' => 'Revision',
						'foreignKey' => 'revision_id',
				),
	);
	
	var $hasAndBelongsToMany = array(
			'Tag',
			'Group'
			);

	var $hasMany = array(
			'Revision' => array('order' => 'Revision.created DESC')
	);	
	
	
	
	/**
	* Takes a list of comma-seperated tags and saves this tags to the mindmap with the id mindmap_id and to the user with the id user_id
	*/
/**
 * Takes a list of comma-seperated tags and saves this tags 
 * to the mindmap with the id mindmap_id and to the user with the id user_id
 * @param int $mindmap_id 
 * @param int $user_id
 * @param string $tags a string with comma-seperated tags
 * @return void 
 */     	
	function saveTags($mindmap_id, $user_id, $tags)
	{
		$tags = explode(',', $tags);
		foreach($tags as $tag)
		{
			$tag = trim($tag);
			if(!empty($tag))
			{
				$this->Tag->contain();
				$res = $this->Tag->findByTextAndUserId($tag, $user_id);
				if(!empty($res['Tag']['text']))
				{
					$save['Tag']['Tag'][] = $res['Tag']['id'];
				}
				else
				{
				 	$this->Tag->create();
					$this->Tag->save(array('text'=>$tag, 'user_id'=>$user_id));
					$save['Tag']['Tag'][] = $this->Tag->getLastInsertId();
				}
			}
		}
		if(isset($save))
		{
			$this->save($save);	
		}
	}
	
/**
 * Loads the tags for a mindmap and returns it as a comma-seperated string
 * @param int $mindmap_id
 * @return string comma-seperated list of tags
 */   	
	function loadTags($mindmap_id)
	{
		$this->contain('Tag.text');
		$tags = $this->findById($mindmap_id);
		$arr = array();
	
		foreach($tags['Tag'] as $tag)
		{
			$arr[] = $tag['text'];
		}
		
		return implode(',', $arr);
	}
	
	
	
/**
 * Checks if a user has rights to edit a mindmap
 * 	function returns true if the user is the owner of a map
 *		or if the  mindmap is accessible through a group in which the user is a member 	  
 * @param int $mindmap_id the id of the mindmap
 * @param int $user_id the user
 * @return boolean returns true if the user has the right to edit the mindmap
 */    		
	function checkAuth($mindmap_id, $user_id)
	{
		$this->contain();
		$map_user_id = $this->field('user_id', array('id'=>$mindmap_id));
		if(!$map_user_id)
		{
			return false;
		}
		
		//check if the User is the owner of this mindmap
		if($map_user_id == $user_id)
		{
			return true;
		}


		//the given user is not the owner of this mindmap
		// so we check if the mindmap is accessible for him via a group
		
		// load all associated groups with all associated users
		$this->contain('Group.User');
		$mindmap = $this->findById($mindmap_id);

		//with this extract we get an array of user_ids for each group
		// so we loop through these array and check if the user_id-array contains our $user_id
		$groups = Set::extract($mindmap, 'Group.{n}.User.{n}.id');
		foreach($groups as $group)
		{
			if(in_array($user_id, $group))
			{
				return true;
			}
		}
		return false;
	}
	
	
/**
 * Locks a mindmap
 * @param int $mindmap_id the id of the mindmap to lock
 * @param int $user_id the user who owns the lock
 * @return boolean returns true on success
 */    	
	function lock($mindmap_id, $user_id)
	{
		$this->id = $mindmap_id;
		$this->saveField('lock_time', date('Y-m-d H:i:s'));
		$this->saveField('lock_user_id', $user_id);
		return true;
	}
	
/**
 * Duplicates a mindmap - create a copy of a mindmap and store it for the given user
 * @param int $mindmap_id the id of the mindmap to duplicate
 * @param int $user_id the user 
 * @return mixed returns the id of the created mindmap on success, or false
 */    	
	function duplicate($mindmap_id, $user_id)
	{
		//find the mindmap
		$this->contain('Data');
		$mindmap = $this->findById($mindmap_id);
		if(!$mindmap)
		{
			pr('Mindmap not found');
			return false;
		}
		$data = array();
		$data['user_id'] = $user_id;
		$data['name'] = $mindmap[$this->name]['name'].' - copy';
		$this->create();
		if($this->save($data))
		{
			$id = $this->getLastInsertID();
			$data = array();
			$data['data'] = $mindmap['Data']['data'];
			$data['user_id'] = $mindmap['Data']['user_id'];
			$data['mindmap_id'] = $id;
			if($this->Revision->save($data))
			{
				$revision_id = $this->Revision->getLastInsertID();
				$this->id = $id;
				$this->saveField('revision_id', $revision_id);
				return $id;				
			}
			else
			{
				pr('Revision not created');
				return false;
			}
		}
		else
		{
			pr('Mindmap not created');
			return false;
		}		
	}
	
	
	
/**
 * Checks if a mindmap is locked for a user
 * @param int $mindmap_id The id of the mindmap to check
 * @param int $user_id The id of the logged in user
 * @return boolean returns true if the mindmap is locked otherwise false
 */     	
	function isLocked($mindmap_id, $user_id)
	{
		$this->contain();
		$res = $this->findById($mindmap_id, 'lock_time, lock_user_id');
		$lock_user_id = $res[$this->name]['lock_user_id'];
		
		//if the lock_user_id is 0, the map was never locked, 
		//if it's the same as $user_id it's locked by the given user and therefore "unlocked"
		if(in_array($lock_user_id, array(0, $user_id)))
		{
			return false;
		}

		$lock_time = strtotime($res[$this->name]['lock_time']);
		//@TODO no magic-numbers....replace with constant...
		if(time() - $lock_time < 2*60) // check how long ago the lock is...
		{
			return true;
		}

		return false;
	}
	
/**
 * Saves a mindmap
 * expects an array with the following indices:
 * 	data: the mindmap-xml to save
 * 	id: the id of the mindmap
 * 	user_id: the id of the user who is logged in
 *      
 * @param array $save An array that contains the data to save the id of the mindmap and a user_id
 * @return boolean returns true on success
 */    	
	function saveMindmap($save)
	{
		if(empty($save['data']) || empty($save['id']) || empty($save['user_id']))
		{
			return false;
		}
		
		$array = array();
		$array['data'] = $save['data'];
		$array['user_id'] = $save['user_id'];
		$array['mindmap_id'] = $save['id'];
		
		$this->Revision->save($array);
		$revision_id = $this->Revision->getLastInsertId();
		
		$array = array();
		$array['id'] = $save['id'];
		$array['data'] = $save['data'];
		$array['revision_id'] = $revision_id;
		$this->save($array);
		
		return true;
	}
	
}
