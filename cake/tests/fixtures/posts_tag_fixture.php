<?php
/* SVN FILE: $Id: posts_tag_fixture.php 7062 2008-05-30 11:29:53Z nate $ */
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
class PostsTagFixture extends CakeTestFixture {
	var $name = 'PostsTag';
	var $fields = array(
		'post_id' => array('type' => 'integer', 'null' => false),
		'tag_id' => array('type' => 'string', 'null' => false),
	);

	var $records = array(
		array('post_id' => 1, 'tag_id' => 'tag1'),
		array('post_id' => 1, 'tag_id' => 'tag2'),
		array('post_id' => 2, 'tag_id' => 'tag1'),
		array('post_id' => 2, 'tag_id' => 'tag3')
	);
}

?>