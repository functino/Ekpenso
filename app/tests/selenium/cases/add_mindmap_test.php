<?php
// app/tests/selenium/cases/login_test.php
class AddMindmapTest extends SeleniumTestCase {
    var $title = 'Add-Mindmap-Test';

    function setUp() {

    }

    function tearDown() {
    }

	function execute() {
		$this->open('/');
		$this->type('name=data[User][email]', 'mail@example.com');
		$this->type('name=data[User][password]', 'password');
		$this->clickAndWait('//button[@type=\'submit\']');
		$this->type('id=MindmapName','Selenium-Testmap');
		$this->clickAndWait('//div[@id=\'content\']/div/div[1]/form/button');
		$this->clickAndWait('link=zurück zur Startseite');
		$this->clickAndWait('link=löschen');
		$this->assertConfirmation('Bist du dir sicher, dass du die Mindmap \'Selenium-Testmap\' löschen willst?');
		$this->assertTextPresent('Mindmap gelöscht');
		$this->clickAndWait('link=Logout');
	}
}