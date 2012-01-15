<?php
/* SVN FILE: $Id: auth.test.php 28 2008-06-02 16:49:56Z ageier $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package			cake
 * @subpackage		cake.cake.tests.cases.libs.controller.components
 * @since			CakePHP(tm) v 1.2.0.5347
 * @version			$Revision: 28 $
 * @modifiedby		$LastChangedBy: ageier $
 * @lastmodified	$Date: 2008-06-02 18:49:56 +0200 (Mo, 02 Jun 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import(array('controller' . DS . 'components' . DS .'auth', 'controller' . DS . 'components' . DS .'acl'));

App::import(array('controller'.DS.'components'.DS.'acl', 'model'.DS.'db_acl'));
Configure::write('Security.salt', 'JfIxfs2guVoUubWDYhG93b0qyJfIxfs2guwvniR2G0FgaC9mi');
/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class TestAuthComponent extends AuthComponent {

	var $testStop = false;

	function stop() {
		$this->testStop = true;
	}
}

/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class AuthUser extends CakeTestModel {
	var $name = 'AuthUser';
	var $useDbConfig = 'test_suite';

	function parentNode() {
		return true;
	}

	function bindNode($object) {
		return 'Roles/Admin';
	}

	function isAuthorized($user, $controller = null, $action = null) {
		if (!empty($user)) {
			return true;
		}
		return false;
	}
}
/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class AuthTestController extends Controller {
	var $name = 'AuthTest';
	var $uses = array('AuthUser');
	var $components = array('Auth', 'Acl');

	var $testUrl = null;

	function __construct() {
		$this->params = Router::parse('/auth_test');
		Router::setRequestInfo(array($this->params, array('base' => null, 'here' => '/auth_test', 'webroot' => '/', 'passedArgs' => array(), 'argSeparator' => ':', 'namedArgs' => array())));
		parent::__construct();
	}

	function beforeFilter() {
	}

	function login() {
	}

	function admin_login() {
	}

	function logout() {
		//$this->redirect($this->Auth->logout());
	}

	function add() {
		echo "add";
	}

	function redirect($url, $status, $exit) {
		$this->testUrl = Router::url($url);
		return false;
	}

	function isAuthorized() {
		if(isset($this->params['testControllerAuth'])) {
			return false;
		}
		return true;
	}
}

class AjaxAuthController extends Controller {
	var $name = 'AjaxAuth';
	var $components = array('TestAuth');
	var $uses = array();
	var $testUrl = null;

	function beforeFilter() {
		$this->TestAuth->ajaxLogin = 'test_element';
		$this->TestAuth->userModel = 'AuthUser';
	}
	function add() {
		if ($this->TestAuth->testStop !== true) {
			echo 'Added Record';
		}
	}
	function redirect($url, $status, $exit) {
		$this->testUrl = Router::url($url);
		return false;
	}
}
/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class AuthTest extends CakeTestCase {
	var $name = 'Auth';

	var $fixtures = array('core.auth_user', 'core.aro', 'core.aco', 'core.aros_aco', 'core.aco_action');

	var $initialized = false;

	function startTest() {
		if (!$this->initialized) {
			Configure::write('Acl.database', 'test_suite');
			Configure::write('Acl.classname', 'DbAcl');
			if (isset($this->fixtures) && (!is_array($this->fixtures) || empty($this->fixtures))) {
				unset($this->fixtures);
			}

			// Create records
			if (isset($this->_fixtures) && isset($this->db)) {
				foreach ($this->_fixtures as $fixture) {
					$fixture->insert($this->db);
				}
			}
		}

		$this->Controller =& new AuthTestController();

		$this->Controller->Component->init($this->Controller);
		ClassRegistry::addObject('view', new View($this->Controller));
		$this->Controller->Session->del('Auth');
		$this->Controller->Session->del('Message.auth');
		$this->initialized = true;
	}

	function testNoAuth() {
		$this->assertFalse($this->Controller->Auth->isAuthorized());
	}

	function testLogin() {
		$this->AuthUser =& new AuthUser();
		$user['id'] = 1;
		$user['username'] = 'mariano';
		$user['password'] = Security::hash(Configure::read('Security.salt') . 'cake');
		$this->AuthUser->save($user, false);

		$authUser = $this->AuthUser->find();

		$this->Controller->data['AuthUser']['username'] = $authUser['AuthUser']['username'];
		$this->Controller->data['AuthUser']['password'] = 'cake';

		$this->Controller->params['url']['url'] = 'auth_test/login';

		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = 'auth_test/login';
		$this->Controller->Auth->userModel = 'AuthUser';

		$this->Controller->Auth->startup($this->Controller);
		$user = $this->Controller->Auth->user();
		$expected = array('AuthUser' => array(
			'id' => 1, 'username' => 'mariano', 'created' => '2007-03-17 01:16:23', 'updated' => date('Y-m-d H:i:s')
		));
		$this->assertEqual($user, $expected);
		$this->Controller->Session->del('Auth');

		$this->Controller->data['AuthUser']['username'] = 'blah';
		$this->Controller->data['AuthUser']['password'] = '';

		$this->Controller->Auth->startup($this->Controller);

		$user = $this->Controller->Auth->user();
		$this->assertFalse($user);
		$this->Controller->Session->del('Auth');

		$this->Controller->data['AuthUser']['username'] = 'now() or 1=1 --';
		$this->Controller->data['AuthUser']['password'] = '';

		$this->Controller->Auth->startup($this->Controller);

		$user = $this->Controller->Auth->user();
		$this->assertFalse($user);
		$this->Controller->Session->del('Auth');

		$this->Controller->data['AuthUser']['username'] = 'now() or 1=1 # something';
		$this->Controller->data['AuthUser']['password'] = '';

		$this->Controller->Auth->startup($this->Controller);

		$user = $this->Controller->Auth->user();
		$this->assertFalse($user);
		$this->Controller->Session->del('Auth');

	}

	function testAuthorizeFalse() {
		$this->AuthUser =& new AuthUser();
		$user = $this->AuthUser->find();
		$this->Controller->Session->write('Auth', $user);
		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->authorize = false;
		$result = $this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($result);

		$this->Controller->Session->del('Auth');
		$result = $this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
	}

	function testAuthorizeController(){
		$this->AuthUser =& new AuthUser();
		$user = $this->AuthUser->find();
		$this->Controller->Session->write('Auth', $user);
		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->authorize = 'controller';
		$result = $this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($result);

		$this->Controller->params['testControllerAuth'] = 1;
		$result = $this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
		$this->assertFalse($result);

		$this->Controller->Session->del('Auth');
	}

	function testAuthorizeModel() {
		$this->AuthUser =& new AuthUser();
		$user = $this->AuthUser->find();
		$this->Controller->Session->write('Auth', $user);

		$this->Controller->params['controller'] = 'auth_test';
		$this->Controller->params['action'] = 'add';
		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->initialize($this->Controller);
		$this->Controller->Auth->authorize = array('model'=>'AuthUser');
		$result = $this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($result);

		$this->Controller->Session->del('Auth');
		$this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
		$result = $this->Controller->Auth->isAuthorized();
		$this->assertFalse($result);

	}

	function testAuthorizeCrud() {
		$this->AuthUser =& new AuthUser();
		$user = $this->AuthUser->find();
		$this->Controller->Session->write('Auth', $user);

		$this->Controller->params['controller'] = 'auth_test';
		$this->Controller->params['action'] = 'add';

		$this->Controller->Acl->name = 'DbAclTest';

		$this->Controller->Acl->Aro->id = null;
		$this->Controller->Acl->Aro->create(array('alias'=>'Roles'));
		$result = $this->Controller->Acl->Aro->save();
		$this->assertTrue($result);

		$parent = $this->Controller->Acl->Aro->id;

		$this->Controller->Acl->Aro->create(array('parent_id'=> $parent, 'alias'=>'Admin'));
		$result = $this->Controller->Acl->Aro->save();
		$this->assertTrue($result);

		$parent = $this->Controller->Acl->Aro->id;

		$this->Controller->Acl->Aro->create(array('model' => 'AuthUser', 'parent_id' => $parent, 'foreign_key' => 1, 'alias'=> 'mariano'));
		$result = $this->Controller->Acl->Aro->save();
		$this->assertTrue($result);

		$this->Controller->Acl->Aco->create(array('alias'=>'Root'));
		$result = $this->Controller->Acl->Aco->save();
		$this->assertTrue($result);

		$parent = $this->Controller->Acl->Aco->id;

		$this->Controller->Acl->Aco->create(array('parent_id' => $parent, 'alias' => 'AuthTest'));
		$result = $this->Controller->Acl->Aco->save();
		$this->assertTrue($result);

		$this->Controller->Acl->allow('Roles/Admin', 'Root');
		$this->Controller->Acl->allow('Roles/Admin', 'Root/AuthTest');

		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->authorize = 'crud';
		$this->Controller->Auth->actionPath = 'Root/';

		$this->Controller->Auth->startup($this->Controller);


		$this->assertTrue($this->Controller->Auth->isAuthorized());

		$this->Controller->Session->del('Auth');
		$this->Controller->Auth->startup($this->Controller);
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
	}

	function testLoginRedirect() {
		if (isset($_SERVER['HTTP_REFERER'])) {
			$backup = $_SERVER['HTTP_REFERER'];
		} else {
			$backup = null;
		}

		$_SERVER['HTTP_REFERER'] = false;

		$this->Controller->Session->write('Auth', array('AuthUser' => array('id'=>'1', 'username'=>'nate')));

		$this->Controller->params['url']['url'] = 'users/login';
		$this->Controller->Auth->initialize($this->Controller);

 		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'welcome');
		$this->Controller->Auth->startup($this->Controller);
		$expected = Router::normalize($this->Controller->Auth->loginRedirect);
		$this->assertEqual($expected, $this->Controller->Auth->redirect());

		$this->Controller->Session->del('Auth');

		$this->Controller->params['url']['url'] = 'admin/';
		$this->Controller->Auth->initialize($this->Controller);
 		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->loginRedirect = null;
		$this->Controller->Auth->startup($this->Controller);
		$expected = Router::normalize('admin/');
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
		$this->assertEqual($expected, $this->Controller->Auth->redirect());

		$this->Controller->Session->del('Auth');

		$_SERVER['HTTP_REFERER'] = '/admin/';

		$this->Controller->Session->write('Auth', array('AuthUser' => array('id'=>'1', 'username'=>'nate')));

		$this->Controller->params['url']['url'] = 'auth_test/login';

		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = 'auth_test/login';

 		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->loginRedirect = false;
		$this->Controller->Auth->startup($this->Controller);
		$expected = Router::normalize('admin');
		$this->assertEqual($expected, $this->Controller->Auth->redirect());

		//Ticket #4750
		//named params
		$this->Controller->Session->del('Auth');
		$url = '/posts/index/year:2008/month:feb';
		$this->Controller->params = Router::parse($url);
		$this->Controller->Auth->initialize($this->Controller);
		$this->Controller->Auth->loginAction = array('controller' => 'AuthTest', 'action' => 'login');
 		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->startup($this->Controller);
		$expected = Router::normalize('posts/index/year:2008/month:feb');
		$this->assertEqual($expected, $this->Controller->Session->read('Auth.redirect'));

		//passed args
		$this->Controller->Session->del('Auth');
		$url = '/posts/view/1';
		$this->Controller->params = Router::parse($url);
		$this->Controller->Auth->initialize($this->Controller);
		$this->Controller->Auth->loginAction = array('controller' => 'AuthTest', 'action' => 'login');
 		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->startup($this->Controller);
		$expected = Router::normalize('posts/view/1');
		$this->assertEqual($expected, $this->Controller->Session->read('Auth.redirect'));


		$_SERVER['HTTP_REFERER'] = $backup;
		$this->Controller->Session->del('Auth');
	}

	function testEmptyUsernameOrPassword() {
		$this->AuthUser =& new AuthUser();
		$user['id'] = 1;
		$user['username'] = 'mariano';
		$user['password'] = Security::hash(Configure::read('Security.salt') . 'cake');
		$this->AuthUser->save($user, false);

		$authUser = $this->AuthUser->find();

		$this->Controller->data['AuthUser']['username'] = '';
		$this->Controller->data['AuthUser']['password'] = '';

		$this->Controller->params['url']['url'] = 'auth_test/login';

		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = 'auth_test/login';
		$this->Controller->Auth->userModel = 'AuthUser';

		$this->Controller->Auth->startup($this->Controller);
		$user = $this->Controller->Auth->user();
		$this->assertTrue($this->Controller->Session->check('Message.auth'));
		$this->assertEqual($user, false);
		$this->Controller->Session->del('Auth');
	}

	function testInjection() {
		$this->AuthUser =& new AuthUser();
		Configure::write('debug', 1);
		$this->AuthUser->id = 2;
		$this->AuthUser->saveField('password', Security::hash(Configure::read('Security.salt') . 'cake'));

		$this->Controller->data['AuthUser']['username'] = 'nate';
		$this->Controller->data['AuthUser']['password'] = 'cake';
		$this->Controller->params['url']['url'] = 'auth_test/login';
		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = 'auth_test/login';
		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->startup($this->Controller);
		$this->assertTrue(is_array($this->Controller->Auth->user()));

		$this->Controller->Session->del($this->Controller->Auth->sessionKey);

		$this->Controller->data['AuthUser']['username'] = 'nate';
		$this->Controller->data['AuthUser']['password'] = 'cake1';
		$this->Controller->params['url']['url'] = 'auth_test/login';
		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = 'auth_test/login';
		$this->Controller->Auth->userModel = 'AuthUser';
		$this->Controller->Auth->startup($this->Controller);
		$this->assertTrue(is_null($this->Controller->Auth->user()));

		$this->Controller->Session->del($this->Controller->Auth->sessionKey);

		$this->Controller->data['AuthUser']['username'] = '> n';
		$this->Controller->data['AuthUser']['password'] = 'cake';
		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->startup($this->Controller);
		$this->assertTrue(is_null($this->Controller->Auth->user()));
	}

	function testCustomRoute() {
		Router::reload();
		Router::connect('/:lang/:controller/:action/*', array('lang' => null), array('lang' => '[a-z]{2,3}'));

		$url = '/en/users/login';
		$this->Controller->params = Router::parse($url);
		Router::setRequestInfo(array($this->Controller->passedArgs, array('base' => null, 'here' => $url, 'webroot' => '/', 'passedArgs' => array(), 'argSeparator' => ':', 'namedArgs' => array())));

		$this->AuthUser =& new AuthUser();
		$user = array('id' => 1, 'username' => 'felix', 'password' => Security::hash(Configure::read('Security.salt') . 'cake'));
		$user = $this->AuthUser->save($user, false);

		$this->Controller->data['AuthUser'] = array('username' => 'felix', 'password' => 'cake');
		$this->Controller->params['url']['url'] = substr($url, 1);
		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Controller->Auth->userModel = 'AuthUser';

		$this->Controller->Auth->startup($this->Controller);
		$user = $this->Controller->Auth->user();
		$this->assertTrue(!!$user);
	}

	function testAdminRoute() {
		Router::reload();
		$admin = Configure::read('Routing.admin');
		Configure::write('Routing.admin', 'admin');

		$url = '/admin/something';
		$this->Controller->params = Router::parse($url);
		$this->Controller->params['url']['url'] = ltrim($url, '/');
		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'index', 'plugin' => null, 'controller' => 'something',
				'admin' => true, 'url' => array('url' => $this->Controller->params['url']['url']),
			),
			array(
				'base' => null, 'here' => $url,
				'webroot' => '/', 'passedArgs' => array(),
			)
		));
		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = array('admin' => true, 'controller' => 'auth_test', 'action' => 'login');
		$this->Controller->Auth->userModel = 'AuthUser';

		$this->Controller->Auth->startup($this->Controller);
		$this->assertEqual($this->Controller->testUrl, '/admin/auth_test/login');

		Configure::write('Routing.admin', $admin);
	}

	function testAjaxLogin() {
		Configure::write('viewPaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'views'. DS));
		$_SERVER['HTTP_X_REQUESTED_WITH'] = "XMLHttpRequest";

		if (!class_exists('dispatcher')) {
			require CAKE . 'dispatcher.php';
		}

		ob_start();
		$Dispatcher =& new Dispatcher();
		$Dispatcher->dispatch('/ajax_auth/add', array('return' => 1));
		$result = ob_get_clean();
		$this->assertPattern('/test element/', $result);
		$this->assertNoPattern('/Added Record/', $result);
		unset($_SERVER['HTTP_X_REQUESTED_WITH']);
	}

	function testLoginActionRedirect() {
		Router::reload();
		$admin = Configure::read('Routing.admin');
		Configure::write('Routing.admin', 'admin');

		$url = '/admin/auth_test/login';
		$this->Controller->params = Router::parse($url);
		$this->Controller->params['url']['url'] = ltrim($url, '/');
		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'admin_login', 'plugin' => null, 'controller' => 'auth_test',
				'admin' => true, 'url' => array('url' => $this->Controller->params['url']['url']),
			),
			array(
				'base' => null, 'here' => $url,
				'webroot' => '/', 'passedArgs' => array(),
			)
		));

		$this->Controller->Auth->initialize($this->Controller);

		$this->Controller->Auth->loginAction = array('admin' => true, 'controller' => 'auth_test', 'action' => 'login');
		$this->Controller->Auth->userModel = 'AuthUser';

		$this->Controller->Auth->startup($this->Controller);

		$this->assertNull($this->Controller->testUrl);

		Configure::write('Routing.admin', $admin);
	}

	function tearDown() {
		unset($this->Controller, $this->AuthUser);
	}
}
?>