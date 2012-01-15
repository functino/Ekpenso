<?php
/* SVN FILE: $Id: story_fixture.php 28 2008-06-02 16:49:56Z ageier $ */
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
 * @link			https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package			cake.tests
 * @subpackage		cake.tests.fixtures
 * @since			CakePHP(tm) v 1.2.0.4667
 * @version			$Revision: 28 $
 * @modifiedby		$LastChangedBy: ageier $
 * @lastmodified	$Date: 2008-06-02 18:49:56 +0200 (Mo, 02 Jun 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.fixtures
 */
class StoryFixture extends CakeTestFixture {
	var $name = 'Story';
	var $fields = array(
		'story' => array('type' => 'integer', 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false)
	);
	var $records = array(
		array('title' => 'First Story'),
		array('title' => 'Second Story')
	);
}
?>