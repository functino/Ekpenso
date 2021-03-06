<?php
/* SVN FILE: $Id: db_acl.test.php 28 2008-06-02 16:49:56Z ageier $ */
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
 * @package			cake.tests
 * @subpackage		cake.tests.cases.libs.controller.components.dbacl.models
 * @since			CakePHP(tm) v 1.2.0.4206
 * @version			$Revision: 28 $
 * @modifiedby		$LastChangedBy: ageier $
 * @lastmodified	$Date: 2008-06-02 18:49:56 +0200 (Mo, 02 Jun 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
	define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
}

App::import('Component', 'Acl');
App::import('Core', 'db_acl');

/**
* DB ACL wrapper test class
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAclNodeTestBase extends AclNode {
	var $useDbConfig = 'test_suite';
	var $cacheSources = false;
}

/**
* Aro Test Wrapper
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAroTest extends DbAclNodeTestBase {
	var $name = 'DbAroTest';
	var $useTable = 'aros';
	var $hasAndBelongsToMany = array('DbAcoTest' => array('with' => 'DbPermissionTest'));
}

/**
* Aco Test Wrapper
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAcoTest extends DbAclNodeTestBase {
	var $name = 'DbAcoTest';
	var $useTable = 'acos';
	var $hasAndBelongsToMany = array('DbAroTest' => array('with' => 'DbPermissionTest'));
}

/**
* Permission Test Wrapper
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbPermissionTest extends CakeTestModel {
	var $name = 'DbPermissionTest';
	var $useTable = 'aros_acos';
	var $cacheQueries = false;
	var $belongsTo = array('DbAroTest' => array('foreignKey' => 'aro_id'), 'DbAcoTest' => array('foreignKey' => 'aco_id'));
}
/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAcoActionTest extends CakeTestModel {
	var $name = 'DbAcoActionTest';
	var $useTable = 'aco_actions';
	var $belongsTo = array('DbAcoTest' => array('foreignKey' => 'aco_id'));
}
/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAroUserTest extends CakeTestModel {
	var $name = 'AuthUser';
	var $useTable = 'auth_users';
	
	function bindNode($ref = null) {
		if (Configure::read('DbAclbindMode') == 'string') {
			return 'ROOT/admins/Gandalf';
		} elseif (Configure::read('DbAclbindMode') == 'array') {
			return array('DbAroTest' => array('DbAroTest.model' => 'AuthUser', 'DbAroTest.foreign_key' => 2));
		}
	}
}

/**
* Short description for class.
*
* @package		cake.tests
* @subpackage	cake.tests.cases.libs.controller.components
*/
class DbAclTest extends DbAcl {

	function __construct() {
		$this->Aro =& new DbAroTest();
		$this->Aro->Permission =& new DbPermissionTest();
		$this->Aco =& new DbAcoTest();
		$this->Aro->Permission =& new DbPermissionTest();
	}
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.controller.components.dbacl.models
 */
class AclNodeTest extends CakeTestCase {

	var $fixtures = array('core.aro', 'core.aco', 'core.aros_aco', 'core.aco_action', 'core.auth_user');

	function setUp() {
		Configure::write('Acl.classname', 'DbAclTest');
		Configure::write('Acl.database', 'test_suite');
	}

	function testNode(){
		$Aco = new DbAcoTest();
		$result = Set::extract($Aco->node('Controller1'), '{n}.DbAcoTest.id');
		$expected = array(2, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller1/action1'), '{n}.DbAcoTest.id');
		$expected = array(3, 2, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller2/action1'), '{n}.DbAcoTest.id');
		$expected = array(7, 6, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller1/action2'), '{n}.DbAcoTest.id');
		$expected = array(5, 2, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller1/action1/record1'), '{n}.DbAcoTest.id');
		$expected = array(4, 3, 2, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller2/action1/record1'), '{n}.DbAcoTest.id');
		$expected = array(8, 7, 6, 1);
		$this->assertEqual($result, $expected);

		$result = Set::extract($Aco->node('Controller2/action3'), '{n}.DbAcoTest.id');
		$this->assertFalse($result);

		$result = Set::extract($Aco->node('Controller2/action3/record5'), '{n}.DbAcoTest.id');
		$this->assertFalse($result);
		
		$result = $Aco->node('');
		$this->assertEqual($result, null);
	}
	
	function testNodeArrayFind() {
		$Aro = new DbAroTest();
		Configure::write('DbAclbindMode', 'string');
		$result = Set::extract($Aro->node(array('DbAroUserTest' => array('id' => '1', 'foreign_key' => '1'))), '{n}.DbAroTest.id');
		$expected = array(3, 2, 1);
		$this->assertEqual($result, $expected);

		Configure::write('DbAclbindMode', 'array');
		$result = Set::extract($Aro->node(array('DbAroUserTest' => array('id' => 4, 'foreign_key' => 2))), '{n}.DbAroTest.id');
		$expected = array(4);
		$this->assertEqual($result, $expected);	
	}
	
	function testNodeObjectFind() {
		$Aro = new DbAroTest();
		$Model = new DbAroUserTest();
		$Model->id = 1;
		$result = Set::extract($Aro->node($Model), '{n}.DbAroTest.id');
		$expected = array(3, 2, 1);
		$this->assertEqual($result, $expected);
		
		$Model->id = 2;
		$result = Set::extract($Aro->node($Model), '{n}.DbAroTest.id');
		$expected = array(4, 2, 1);
		$this->assertEqual($result, $expected);
		
	}

	function testNodeAliasParenting() {
		$Aco = new DbAcoTest();
		$db =& ConnectionManager::getDataSource('test_suite');
		$db->truncate($Aco);
		$db->_queriesLog = array();

		$Aco->create(array('model' => null, 'foreign_key' => null, 'parent_id' => null, 'alias' => 'Application'));
		$Aco->save();

		$Aco->create(array('model' => null, 'foreign_key' => null, 'parent_id' => $Aco->id, 'alias' => 'Pages'));
		$Aco->save();

		$result = $Aco->find('all');
		$expected = array(
			array('DbAcoTest' => array('id' => '1', 'parent_id' => null, 'model' => null, 'foreign_key' => null, 'alias' => 'Application', 'lft' => '1', 'rght' => '4'), 'DbAroTest' => array()),
			array('DbAcoTest' => array('id' => '2', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Pages', 'lft' => '2', 'rght' => '3', ), 'DbAroTest' => array())
		);
		$this->assertEqual($result, $expected);
	}
}
?>