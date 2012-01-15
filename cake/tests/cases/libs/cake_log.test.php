<?php
/* SVN FILE: $Id: cake_log.test.php 7062 2008-05-30 11:29:53Z nate $ */
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
 * @subpackage		cake.tests.cases.libs
 * @since			CakePHP(tm) v 1.2.0.5432
 * @version			$Revision: 7062 $
 * @modifiedby		$LastChangedBy: nate $
 * @lastmodified	$Date: 2008-05-30 06:29:53 -0500 (Fri, 30 May 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
uses('cake_log');
/**
 * Short description for class.
 *
 * @package    cake.tests
 * @subpackage cake.tests.cases.libs
 */
class CakeLogTest extends UnitTestCase {

	function testLogFileWriting() {
		@unlink(LOGS . 'error.log');
		CakeLog::write(LOG_WARNING, 'Test warning');
		$this->assertTrue(file_exists(LOGS . 'error.log'));
		unlink(LOGS . 'error.log');

		CakeLog::write(LOG_WARNING, 'Test warning 1');
		CakeLog::write(LOG_WARNING, 'Test warning 2');
		$result = file_get_contents(LOGS . 'error.log');
		$this->assertPattern('/^2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Warning: Test warning 1/', $result);
		$this->assertPattern('/2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Warning: Test warning 2$/', $result);
		unlink(LOGS . 'error.log');
	}
}

?>