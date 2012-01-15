<?php
class PagesController extends AppController{
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		if (!func_num_args()) {
			$this->redirect('/');
		}
		$path = func_get_args();

		if (!count($path)) {
			$this->redirect('/');
		}
		$count = count($path);
		$page = null;
		$subpage = null;
		$title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set('page', $page);
		$this->set('subpage', $subpage);
		$this->set('title', $title);
		$this->render(join('/', $path));
	}
	
	function contact()
	{
		$this->set('_tab', 'contact');
	}
	
	function help()
	{
		$this->set('_tab', 'help');
	}
	
	function downloads()
	{
		$this->set('_tab', 'downloads');
	}
	
	function home()
	{
		//User is logged in - take him to the members-view...
		if($this->Session->check('User'))
		{
			$this->redirect('/users/hello');
		}
	}
	
	function download($file)
	{
		//@TODO this is just a quick hack
		App::import('Model', 'Download');
		$download = new Download();
		
		$arr = array();
		$arr['file'] = $file;
		if($this->Session->check('User'))
		{
			$arr['user_id'] = $this->Session->read('User.id');	
		}
		else
		{
			$arr['user_id'] = 0;
		}
		
		$download->save($arr);
		
		$this->redirect('/files/'.$file);
	}
}
?>