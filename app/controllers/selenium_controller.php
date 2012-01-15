<?php
/** 
 * Controller for executing selenium tests.
 *
 * Requires Selenium Core 0.8.1  (http://www.openqa.org/selenium-core/)
 *
 * Copyright: Daniel Hofstetter  (http://cakebaker.42dh.com)
 * License: MIT
 *
 * For installation instructions, see http://cakebaker.42dh.com/tags/selenium/
 * Selenium documentation: http://www.openqa.org/selenium-core/reference.html
*/	
	define('SELENIUM_TESTS', APP.'tests'.DS.'selenium');

	//vendor('selenium'.DS.'selenium_test_suite', 'selenium'.DS.'selenium_test_case');
	App::import('Vendor', 'selenium'.DS.'selenium_test_suite');
	App::import('Vendor', 'selenium'.DS.'selenium_test_case');
	class SeleniumController extends AppController {
		var $uses = null;
		var $autoRender = false;
		
		function display() {
			Configure::write('debug', '0');
			$path = func_get_args();
			
			switch (count($path)) {
				case 1:
					$this->__executeTestSuite($path[0]);
					break;
				case 2:
					$this->__executeTestCase($path[0], $path[1]);
					break;
				case 3:
					if ($path[0] == 'setup') {
						$this->__executeSetup($path[1], $path[2]);
					} else {
						$this->__executeTearDown($path[1], $path[2]);
					}
					break;
				default:
					$this->__executeAllTestSuite();
					break;
			}			
		}
		
		function __executeAllTestSuite() {
			$this->__docBegin('Test Suite');
			$allTestSuite = new SeleniumTestSuite();
			$allTestSuite->title = 'All Tests';
			$allTestSuite->title();
			
			$testSuiteFileNames = listClasses(SELENIUM_TESTS);
			
			foreach ($testSuiteFileNames as $testSuiteFileName) {
				require(SELENIUM_TESTS.DS.$testSuiteFileName);
				$testSuiteName = Inflector::camelize(str_replace('.php', '', $testSuiteFileName));
				$testSuite = new $testSuiteName();
				$testSuite->execute();
			}
			
			$this->__docEnd();
		}
		
		function __executeSetup($folder, $testCaseName) {
			$testCase = $this->__createTestCase($folder, $testCaseName);
			$testCase->setUp();
			$testCase->loadFixtures();
		}
		
		function __executeTearDown($folder, $testCaseName) {
			$testCase = $this->__createTestCase($folder, $testCaseName);
			$testCase->tearDown();
		}
		
		function __executeTestCase($folder, $testCaseName) {
			$testCase = $this->__createTestCase($folder, $testCaseName);
			$this->__docBegin('Test Case');
			$testCase->title();
			$testCase->doExecute($folder, $testCaseName);
			$this->__docEnd();
		}
		
		function __executeTestSuite($testSuiteName) {
			require(SELENIUM_TESTS.DS.Inflector::underscore($testSuiteName).'.php');
			$this->__docBegin('Test Suite');
			$testSuite = new $testSuiteName();
			$testSuite->title();
			$testSuite->execute();
			$this->__docEnd();
		}
		
		function __createTestCase($folder, $testCaseName) {
			require(SELENIUM_TESTS.DS.$folder.DS.Inflector::underscore($testCaseName).'.php');
			return new $testCaseName();
		}
		
		function __docBegin($title) {
			echo '<html><head><title>'.$title.'</title></head><body><table cellpadding="1" cellspacing="1" border="1"><tbody>';
		}
		
		function __docEnd() {
			echo '</tbody></table></body></html>';
		}
	}
?>