<?php
// app/tests/selenium/my_test_suite.php
class MyTestSuite extends SeleniumTestSuite {
    var $title = 'Selenium-Test';

    function execute() {
        $this->addTestCase('Login/Logout-Test', 'cases/LoginTest');
        $this->addTestCase('Add-Mindmap-Test', 'cases/AddMindmapTest');
        $this->addTestCase('Registrierung-Test', 'cases/RegisterTest');
        $this->addTestCase('Feedback-Test', 'cases/FeedbackTest');
    }
}