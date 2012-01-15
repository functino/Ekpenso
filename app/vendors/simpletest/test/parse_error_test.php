<?php
// $Id: parse_error_test.php 1 2008-05-23 23:12:34Z ageier $
require_once('../unit_tester.php');
require_once('../reporter.php');

$test = &new TestSuite('This should fail');
$test->addFile('test_with_parse_error.php');
$test->run(new HtmlReporter());
?>