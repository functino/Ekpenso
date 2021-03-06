<?php
class GearsController extends AppController {

	var $name = 'Gears';
	var $helpers = array('Html', 'Form');
	var $uses = array('Mindmap');
	
	function beforeFilter()
	{
		$this->layout = 'offline';
		parent::beforeFilter();
	}
	
	function index()
	{
		
	}
	
	
/**
 * Takes the mindmaps offline / returns data for Google Gears
 */  	
	function go_offline()
	{
		$this->Auth->check();
		
		$sql = 'SELECT 
					m.id, 
					r.id as revision_id,
					UNIX_TIMESTAMP(m.created)*1000 as created, 
					UNIX_TIMESTAMP(m.modified)*1000 as modified, 
					UNIX_TIMESTAMP(NOW())*1000 as offline,
					r.data,
					m.name
				FROM 
					mindmaps m  
				JOIN 
					revisions r
				ON
					m.revision_id = r.id
				WHERE 
					m.user_id = '.(int) $this->Session->read('User.id');
					
		$res = mysql_query($sql) or die(mysql_error());
		$arr = array();
		while($row = mysql_fetch_assoc($res))
		{
			$arr[] = $row;
		}
		$json_data = json_encode($arr);
		$this->set('json_data', $json_data);
	}
	
/**
 * Action to go back online
 */ 
	function go_online()
	{
		$this->Auth->check();
	}
	
	
/**
 * Get's called by Gears to retrieve the manifest-file
 * specifies which files gears should take offline
 */   	
	function manifest()
	{
		//array of files to take offline
		$files = array();
		$files[] = '/gears/go_offline';
		$files[] = '/js/jquery.js';
		$files[] = '/js/swfobject.js';
		$files[] = '/js/gears_init.js';
		$files[] = '/gears';
		$files[] = '/gears/';
		$files[] = '/css/blueprint/screen.css';
		$files[] = '/css/blueprint/plugins/fancy-type/screen.css';
		$files[] = '/css/blueprint/print.css';
		$files[] = '/css/button.css';
		$files[] = '/css/style.css';
		$files[] = '/js/flashmessage.js';
		$files[] = '/'.Configure::read('Viewer.name');
		
		$this->set('files', $files);
		$this->layout = 'empty';
	}
	
	
/**
 * Get's called by Google Gears to syncrhonize local copies with the server
  */  	
	function sync()
	{
		$this->layout = 'empty';
		if(!$this->Mindmap->checkAuth($_POST['mindmap_id'], $this->Session->read('User.id')))
		{
			echo 'no auth';
			die();
		}
		

		$this->Mindmap->contain();
		$mindmap = $this->Mindmap->findById($_POST['mindmap_id']);
		
		if(empty($mindmap))
		{
			echo 'not found';
		}
		else
		{
			if($mindmap['Mindmap']['revision_id'] == $_POST['revision_id'])
			{
				$save = array();
				$save['data'] = stripslashes($_POST['data']);
				$save['user_id'] = $this->Session->read('User.id');
				$save['id'] = $_POST['mindmap_id'];
				$this->Mindmap->saveMindmap($save);
				
				echo 'ok';
			}
			else
			{
				echo 'Offline: '.$_POST['revision_id'];
				echo "\n".'Online: '.$mindmap['Mindmap']['revision_id'];
			}				
		}
		die();
	}


/**
 * Get's called by Google Gears if a given mindmap in sync() has a newer version on the server than on the client
 * decide via $_POST['version'] if we overwrite the file or create a copy
 */     
	function sync2()
	{
		$this->layout = 'empty';
		if(!$this->Mindmap->checkAuth($_POST['mindmap_id'], $this->Session->read('User.id')))
		{
			echo 'no auth';
			die();
		}
		
		$ok = false;
		if($_POST['version'] == 'overwrite')
		{
			$save = array();
			$save['data'] = stripslashes($_POST['data']);
			$save['user_id'] = $this->Session->read('User.id');
			$save['id'] = $_POST['mindmap_id'];
			$this->Mindmap->saveMindmap($save);
			$ok = true;
		}
		
		if($_POST['version'] == 'copy')
		{
			$id = $this->Mindmap->duplicate($_POST['mindmap_id'], $this->Session->read('User.id'));
			if($id)
			{
				$save = array();
				$save['data'] = stripslashes($_POST['data']);
				$save['user_id'] = $this->Session->read('User.id');
				$save['id'] = $id;
				$this->Mindmap->saveMindmap($save);
				$ok = true;
			}
		}
		
		if($ok)
		{
			echo 'ok';
		}
		else
		{
			echo 'nok';
		}
		die();
	}


/**
 * Called by Google Gears to take a newly created mindmap (on the client) to the server
 */ 
	function create()
	{
		$this->layout = 'empty';
		if(!$this->Session->check('User.id'))
		{
			echo 'no auth';
			die();
		}
		
		$save = array();
		$save['name'] = $_POST['name'];
		$save['user_id'] = $this->Session->read('User.id');
		if($this->Mindmap->save($save))
		{
		 	$id = $this->Mindmap->getLastInsertId();
		 	
			$save = array();
			$save['data'] = stripslashes($_POST['data']);
			$save['user_id'] = $this->Session->read('User.id');
			$save['mindmap_id'] = $id;
			$this->Mindmap->Revision->save($save);
		 	$revision_id = $this->Mindmap->Revision->getLastInsertID();
		 	$this->Mindmap->saveField('revision_id', $revision_id);
		 	
			echo 'ok';
		}
		else
		{
			echo 'error';
		}
		die();
	}
}
?>