<?php
// $Id: simpletest_test.php 1 2008-05-23 23:12:34Z ageier $
require_once(dirname(__FILE__) . '/../autorun.php');
require_once(dirname(__FILE__) . '/../simpletest.php');

SimpleTest::ignore('ShouldNeverBeRunEither');

class ShouldNeverBeRun extends UnitTestCase {
    function testWithNoChanceOfSuccess() {
        $this->fail('Should be ignored');
    }
}

class ShouldNeverBeRunEither extends ShouldNeverBeRun { }

class TestOfStackTrace extends UnitTestCase {

    function testCanFindAssertInTrace() {
        $trace = new SimpleStackTrace(array('assert'));
        $this->assertEqual(
                $trace->traceMethod(array(array(
                        'file' => '/my_test.php',
                        'line' => 24,
                        'function' => 'assertSomething'))),
                ' at [/my_test.php line 24]');
    }
}

class DummyResource { }

class TestOfContext extends UnitTestCase {

    function testCurrentContextIsUnique() {
        $this->assertReference(
                SimpleTest::getContext(),
                SimpleTest::getContext());
    }

    function testContextHoldsCurrentTestCase() {
        $context = &SimpleTest::getContext();
        $this->assertReference($this, $context->getTest());
    }

    function testResourceIsSingleInstanceWithContext() {
        $context = &new SimpleTestContext();
        $this->assertReference(
                $context->get('DummyResource'),
                $context->get('DummyResource'));
    }

    function testClearingContextResetsResources() {
        $context = &new SimpleTestContext();
        $resource = &$context->get('DummyResource');
        $context->clear();
        $this->assertClone($resource, $context->get('DummyResource'));
    }
}
?>