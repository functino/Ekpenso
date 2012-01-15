<?php
// $Id: detached_test.php 1 2008-05-23 23:12:34Z ageier $
require_once('../detached.php');
require_once('../reporter.php');

// The following URL will depend on your own installation.
$command = 'php ' . dirname(__FILE__) . '/visual_test.php xml';

$test = &new TestSuite('Remote tests');
$test->addTestCase(new DetachedTestCase($command));
if (SimpleReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());
?>