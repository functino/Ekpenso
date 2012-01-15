<?php
/** 
 * Base class for selenium test suites.
 *
 * Requires Selenium Core 0.8.1  (http://www.openqa.org/selenium-core/)
 *
 * Copyright: Daniel Hofstetter  (http://cakebaker.42dh.com)
 * License: MIT
 *
 * For installation instructions, see http://cakebaker.42dh.com/tags/selenium/
 * Selenium documentation: http://www.openqa.org/selenium-core/reference.html
*/
	class SeleniumTestSuite {
		var $title = 'Test suite';
		
		/**
		 * Adds a testcase to a suite.
		 */
		function addTestCase($title, $view) {
			$dispatcher = new Dispatcher();
			$base = $dispatcher->baseUrl();
			echo '<tr><td><a href="'.$base.'/selenium/'.$view.'" target="testFrame">'.$title.'</a></td></tr>';
		}
		
		/**
		 * Overwrite this function in subclasses and do add your test cases in this function.
		 */
		function execute() {
			// empty
		}
		
		/**
		 * Outputs the test suite title. This function is automatically called. 
		 */
		function title() {
			echo '<tr><td><b>'.$this->title.'</b></td></tr>';
		}
	}
?>