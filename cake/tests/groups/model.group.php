<?php
/* SVN FILE: $Id: model.group.php 7062 2008-05-30 11:29:53Z nate $ */
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
 * @subpackage		cake.tests.groups
 * @since			CakePHP(tm) v 1.2.0.5517
 * @version			$Revision: 7062 $
 * @modifiedby		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 06:29:53 -0500 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/** ModelGroupTest
 *
 * This test group will run all model-layer and related tests, (behaviors, etc.) excluding
 * database driver-specific tests
 *
 * @package    cake.tests
 * @subpackage cake.tests.groups
 */
class ModelGroupTest extends GroupTest {

	var $label = 'All model tests';

	function ModelGroupTest() {
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'model' . DS . 'model');
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'model' . DS . 'db_acl');
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'model' . DS . 'schema');
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'model' . DS . 'datasources' . DS . 'dbo_source');
		TestManager::addTestCasesFromDirectory($this, CORE_TEST_CASES . DS . 'libs' . DS . 'model' . DS . 'behaviors');
	}
}
?>