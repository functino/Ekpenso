<?php
/* SVN FILE: $Id: dependency_fixture.php 7062 2008-05-30 11:29:53Z nate $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link			http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake.tests
 * @subpackage		cake.tests.fixtures
 * @since			CakePHP(tm) v 1.2.0.6879 //Correct version number as needed**
 * @version			$Revision: 7062 $
 * @modifiedby 		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 06:29:53 -0500 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * @package      cake.tests
 * @subpackage   cake.tests.fixtures
 * @since        CakePHP(tm) v 1.2.0.6879 //Correct version number as needed**
 */
class DependencyFixture extends CakeTestFixture {
	var $name = 'Dependency';
	var $fields = array(
		'child_id' => 'integer',
		'parent_id' => 'integer'
	);
	var $records = array(
		array('child_id' => 1, 'parent_id' => 2),
	);
}

?>