<?php
class MindmapsController extends AppController {

	var $name = 'Mindmaps';
	var $helpers = array('Html', 'Form');

/**
 * List all mindmaps of the logged in user
 */ 
	function index() {
		$this->Auth->check();
		$this->paginate = array('limit' => 10, 'page' => 1, 'order'=>array('name'=>'asc')); 
		$this->Mindmap->recursive = 0;
		
		
		$mindmaps = $this->paginate('Mindmap', array('Mindmap.user_id'=>$this->Session->read('User.id')));
		$this->Mindmap->resetBindings();
		$this->set('mindmaps', $mindmaps);
	}

/**
 * Duplicate the given map
 */ 	
	function duplicate($id)
	{
		$this->Auth->check();
		$this->Mindmap->contain();
		if(!$this->Mindmap->checkAuth($id, $this->Session->read('User.id')))
		{
			$this->Session->setFlash(__('no_auth', true), 'flash_error');
			$this->redirect('/');
			return;
		}
		
		$id = $this->Mindmap->duplicate($id, $this->Session->read('User.id'));
		if($id)
		{
			$this->Session->setFlash(__('flash.Mindmap.duplicated', true));
			$this->redirect('/mindmaps/edit/'.$id);
		}
		else
		{
			$this->Session->setFlash(__('flash.Mindmap.duplicate.fail', true));
			$this->redirect('/');
		}
	}
	
/**
 * Display all public maps
 */ 
	function public_maps() {
		$this->paginate = array('limit' => 10, 'page' => 1, 'order'=>array('name'=>'asc')); 
		$this->Mindmap->contain('User');
		$this->set('mindmaps', $this->paginate('Mindmap', array('public'=>'yes')));
		$this->set('_tab', 'public_maps');
	}

/**
 * Action to display mindmaps for the specified tag
 */ 
	function tags($tag = null)
	{
		$this->Auth->check();
		
		$this->Mindmap->Tag->contain();
		$tags = $this->Mindmap->Tag->findAllByUserId($this->Session->read('User.id'));
		$this->set('tags', $tags);

		if(!empty($tag))
		{
		 	$this->Mindmap->Tag->contain('Mindmap');
			$tag = $this->Mindmap->Tag->findByTextAndUserId($tag, $this->Session->read('User.id'));
			$this->set('tag', $tag);					
		}
		else
		{
			$this->set('tag', false);
		}
	}

/**
 * Action to edit mindmap-settings
 */ 
	function edit($id) {
		$this->Auth->check();
		
		$this->Mindmap->contain('Revision.User', 'Group', 'Group.User', 'Group.Admin');
		$mindmap = $this->Mindmap->findById($id);
		
		$this->set('mindmap', $mindmap);
		if($this->Session->read('User.id') != $mindmap['Mindmap']['user_id'])
		{
			$this->redirect('/');
			$this->Session->setFlash(__('flash.no_auth'), 'flash_error');
		}
		else
		{
			if (!empty($this->data)) 
			{
			 	if(isset($this->data['Mindmap']['tags']))
			 	{
					$this->Mindmap->saveTags($id, $this->Session->read('User.id'), $this->data['Mindmap']['tags']);
				}
				
				$this->Mindmap->id = $id;
				if ($this->Mindmap->save($this->data, array('name', 'public'))) 
				{
					$this->Session->setFlash(__('flash.Mindmap.edit.saved', true));
				} 
				else 
				{
					$this->Session->setFlash(__('flash.Mindmap.edit.failed', true), 'flash_error');
				}				
	
			}
			if (empty($this->data)) 
			{
				$this->data = $mindmap;
				$this->data['Mindmap']['tags'] = $this->Mindmap->loadTags($id);
			}
			
			//get all associated groups of the logged in user - but only the fields id and name
			$this->Mindmap->User->contain(array('Group'=>array('id', 'name')));
			$user = $this->Mindmap->User->findById($this->Session->read('User.id'));
			$list = array();
			foreach($user['Group'] as $group)
			{
				$list[$group['id']] = $group['name'];
			}
			$this->set('groups', $list);	
		}


	}


/**
 * Action to display a mindmap to a user
 */ 
	function viewer($id, $revision_id = null)
	{
		$this->Mindmap->contain('Data');
		$mindmap = $this->Mindmap->findById($id);
		//pr($mindmap);
		$canEdit = $this->Mindmap->checkAuth($id, $this->Session->read('User.id'));
		if(!$canEdit && $mindmap['Mindmap']['public']!="yes")
		{
			$this->Session->setFlash(__('flash.no_auth', true), 'flash_error');
			$this->redirect('/');
			exit();
		}
		
		$isLocked = $this->Mindmap->isLocked($id, $this->Session->read('User.id'));
		
		if($isLocked)
		{
			$this->Session->setFlash(__('Mindmap.is_locked', true), 'flash_error');
			$canEdit = false;
		}
		
		if($canEdit)
		{
			$this->Mindmap->lock($id, $this->Session->read('User.id'));
		}
		
		$this->layout = "viewer";
		$this->set('editable', $canEdit);
		$this->set('mindmap', $mindmap);
		$this->set('revision', $mindmap['Mindmap']['revision_id']);
		if($revision_id != null)
		{
			$this->set('revision', $revision_id);	
		}
	}
	
	
	
/**
 * Action to delete a mindmap
 */ 
	function delete($id)
	{
		$this->Auth->check();
		
		$this->Mindmap->contain();
		$mindmap = $this->Mindmap->findById($id, 'user_id');
		if($mindmap['Mindmap']['user_id'] != $this->Session->read('User.id'))
		{
			$this->Session->setFlash(__('no_auth', true), 'flash_error');
			$this->redirect('/');
			return;
		}
		
		
		$this->Mindmap->del($id);
		
		$this->Session->setFlash(__('flash.Mindmap.delete', true));
		$this->redirect('/mindmaps');
	}



/**
 * Action to create a new Mindmap
 */ 
	function add()
	{
	 	$this->Auth->check();
		
		if(empty($this->data)) 
		{
			$this->render();
		} 
		else 
		{
		 	$this->data['Mindmap']['user_id'] = $this->Session->read('User.id');
		 	$data = 
'<MindMap>
  <MM>
    <Node x_Coord="400" y_Coord="270" PopUp="0" Name="K00001">
      <Text>'.$this->data['Mindmap']['name'].'</Text>
      <Format Underlined="0" Italic="0" Bold="0" Alignment="M" Size_x="30" Size_y="70">
        <Font>Trebuchet MS</Font>
        <FontSize>14</FontSize>
        <FontColor>ffffff</FontColor>
        <BackgrColor>ff0000</BackgrColor>
        <FormatLine>
          <LineColor>000000</LineColor>
          <LineSize>1</LineSize>
          <LineForm>DEFAULT</LineForm>
        </FormatLine>
        <ConnectLine>
          <LineColor>000000</LineColor>
          <LineSize>1</LineSize>
          <LineForm>DEFAULT</LineForm>
        </ConnectLine>
      </Format>
      <ConnectLine>
        <LineColor>000000</LineColor>
        <LineSize>1</LineSize>
      </ConnectLine>
    </Node>
  </MM>
</MindMap>';
			if($this->Mindmap->save($this->data, array('user_id', 'name', 'public'))) 
			{
			 	$id = $this->Mindmap->getLastInsertId();
			 	
				$save = array();
				$save['data'] = $data;
				$save['user_id'] = $this->Session->read('User.id');
				$save['mindmap_id'] = $id;
				$this->Mindmap->Revision->save($save);
			 	$revision_id = $this->Mindmap->Revision->getLastInsertID();
			 	$this->Mindmap->saveField('revision_id', $revision_id);
			 	
				$this->redirect('/mindmaps/viewer/'.$id);
			} 
			else 
			{
				$this->Session->setFlash(__('flash.Mindmap.add.failed', true), 'flash_error');
			}
		}
	}
	
	

	
	
/**
 * Action to export a mindmap in different formats
 */ 
	function export($type, $revision_id)
	{
		$this->layout = 'empty';
		$this->Mindmap->Revision->contain('Mindmap');
		$mindmap = $this->Mindmap->Revision->findById($revision_id);
		
		if(!$this->Mindmap->checkAuth($mindmap['Mindmap']['id'], $this->Session->read('User.id')) && $mindmap['Mindmap']['public']!="yes")
		{
			exit();
		}
		else
		{
			$filename = $mindmap['Mindmap']['name'];
			if($type == 'freemind')
			{
				App::import('vendor', '/conversion/converter');
				$converter = new Converter('ekpenso2freemind');
				$xml = $converter->convert($mindmap['Revision']['data']);
				
				$this->set('xml', $xml);
				$this->set('filename', $filename.'.mm');
			}
			else if($type == 'xml')
			{
				$this->set('xml', $mindmap['Revision']['data']);
				$this->set('filename', $filename.'.xml');	
			}
		}
	}
	
	
/**
 * Action to export a mindmap in different formats
 */ 
	function import($type = false)
	{
		$this->Auth->check();
		if($type)
		{
			$this->set('type', $type);
	        if(isset($_FILES['import']))
	        {
	        	$fileData = file_get_contents($_FILES['import']['tmp_name']);
	        	if($fileData)
	        	{
					switch($type)
					{
						case 'freemind':
								App::import('vendor', '/conversion/converter');
								$converter = new Converter('freemind2ekpenso');
								$xml = $converter->convert($fileData);
							break;
						case 'ekpenso':
								$xml = $fileData;
							break;
					}
					
					//@TODO this is not DRY - code should be in mindmap-model...
					$save = array();
					$save['name'] = 'Import '.date('Y-m-d');
					$save['user_id'] = $this->Session->read('User.id');
					if($this->Mindmap->save($save))
					{
					 	$id = $this->Mindmap->getLastInsertId();
						$save = array();
						$save['data'] = $xml;
						$save['user_id'] = $this->Session->read('User.id');
						$save['mindmap_id'] = $id;
						$this->Mindmap->Revision->save($save);
					 	$revision_id = $this->Mindmap->Revision->getLastInsertID();
					 	$this->Mindmap->saveField('revision_id', $revision_id);
						$this->redirect('/mindmaps/edit/'.$id);
					}					
				}
	        }
		}
	}







/**
 * Get the mindmap-xml for the specified revision
 * is called by the flash-viewer
 */  
	function xml($revision_id)
	{
		$this->layout = 'empty';
		$this->Mindmap->Revision->contain('Mindmap');
		$mindmap = $this->Mindmap->Revision->findById($revision_id);
		
		if(!$this->Mindmap->checkAuth($mindmap['Mindmap']['id'], $this->Session->read('User.id')) && $mindmap['Mindmap']['public']!="yes")
		{
			exit();
		}
		else
		{
			$this->set('xml', $mindmap['Revision']['data']);
		}
	}
	
/**
 * Is called by embedded mindmap-viewers to determine the current revision of a mindmap...
 */ 
	function embed_xml($mindmap_id)
	{
		$this->Mindmap->contain();
		$mindmap = $this->Mindmap->findById($mindmap_id);
		$this->redirect('/mindmaps/xml/'.$mindmap['Mindmap']['revision_id']);
	}


/**
 * Action to save a mindmap
 * is called by the flash-viewer
 * data is given via POST 
 */  	
	function save($id)
	{
	 	
		$this->Auth->check();
		$this->layout = 'empty';
		
				
		$mindmap = $this->Mindmap->findById($id);
		if(!$this->Mindmap->checkAuth($id, $this->Session->read('User.id')))
		{
			exit();
		}
		
		$save = array();
		$save['data'] = stripslashes($_POST['mindmap']);
		$save['user_id'] = $this->Session->read('User.id');
		$save['id'] = $id;
		$this->Mindmap->saveMindmap($save);
	}
	

/**
 * Action to lock a mindmap
 * is called by the Flash-Viewer
 */  
	function lock($id)
	{
		$this->Auth->check();
		$this->Mindmap->lock($id, $this->Session->read('User.id'));
		die();
	}
	
	
/**
 * This method get's called by the Viewer's AutoNode-Feature
 * it takes a word and then gives back a list of strings with new node-texts
 * Currently it uses wikiepdia for suggestions.
 * Parameters are given via POST-Request:
 * 		text - the nodes text
 * 		limit - how many results should be given back   
 */
	function auto_nodes()
	{
		$limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 5;
		$text = $_POST['text'];
		
		$this->layout = 'empty';	
		$url = 'http://%s.wikipedia.org/w/index.php?title=%s&action=edit';
		
		// crawl wikipedia data
		$html = $this->__curlHelper(sprintf($url, Configure::read('Config.language'), urlencode($text)));
		
		// if there is this string we are redirected to another page...
		$pattern = '!#REDIRECT\[\[(.*)\]\]!U';
		if(preg_match($pattern, $html, $matches))
		{
			$text = $matches[1];
			$html = $this->__curlHelper(sprintf($url, Configure::read('Config.language'), urlencode($text)));
		}
		

		preg_match_all('#\[\[([a-zA-Z0-9 _-]*)\]]#u', $html, $matches);
		$nodes = array();
		foreach($matches[1] as $m)
		{
		
			if(!empty($m) && !in_array($m, $nodes))
			{
				$nodes[] = $m;	
			}
			if(count($nodes)>=$limit)
			{
				break;
			}
		}

		$this->set('nodes', $nodes);
	}
	
	
/** 
 * Helper function to crawl a given url and return the content.
 * @param String $url The url to open
 * @return String The content of $url
 */    	
	function __curlHelper($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($ch);		
	}
	
}
?>