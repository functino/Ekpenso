<?php
/* SVN FILE: $Id: flag_tree_fixture.php 28 2008-06-02 16:49:56Z ageier $ */
/**
 * Tree behavior class test fixture.
 *
 * Enables a model object to act as a node-based tree.
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
 * @subpackage		cake.tests.fixtures
 * @since			CakePHP(tm) v 1.2.0.5331
 * @version			$Revision: 28 $
 * @modifiedby		$LastChangedBy: ageier $
 * @lastmodified	$Date: 2008-06-02 18:49:56 +0200 (Mo, 02 Jun 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Flag Tree Test Fixture
 *
 * Like Number Tree, but uses a flag for testing scope parameters
 *
 * @package		cake
 * @subpackage	cake.tests.fixtures
 */
class FlagTreeFixture extends CakeTestFixture {
	var $name = 'FlagTree';
	var $fields = array(
		'id'	=> array('type' => 'integer','key' => 'primary'),
		'name'	=> array('type' => 'string','null' => false),
		'parent_id' => 'integer',
		'lft'	=> array('type' => 'integer','null' => false),
		'rght'	=> array('type' => 'integer','null' => false),
		'flag'	=> array('type' => 'integer','null' => false, 'length' => 1, 'default' => 0)
	);
}

?>
