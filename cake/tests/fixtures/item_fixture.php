<?php
/* SVN FILE: $Id: item_fixture.php 7062 2008-05-30 11:29:53Z nate $ */
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
 * @subpackage		cake.tests.fixtures
 * @since			CakePHP(tm) v 1.2.0.4667
 * @version			$Revision: 7062 $
 * @modifiedby		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 06:29:53 -0500 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.fixtures
 */
class ItemFixture extends CakeTestFixture {
	var $name = 'Item';
	var $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'syfile_id' => array('type' => 'integer', 'null' => false),
		'published' => array('type' => 'boolean', 'null' => false),
		'name' => array('type' => 'string', 'null' => false)
	);
	var $records = array(
		array('syfile_id' => 1, 'published' => 0, 'name' => 'Item 1'),
		array('syfile_id' => 2, 'published' => 0, 'name' => 'Item 2'),
		array('syfile_id' => 3, 'published' => 0, 'name' => 'Item 3'),
		array('syfile_id' => 4, 'published' => 0, 'name' => 'Item 4'),
		array('syfile_id' => 5, 'published' => 0, 'name' => 'Item 5'),
		array('syfile_id' => 6, 'published' => 0, 'name' => 'Item 6')
	);
}
?>