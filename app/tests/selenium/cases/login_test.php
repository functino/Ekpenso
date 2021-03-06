<?php
// app/tests/selenium/cases/login_test.php
class LoginTest extends SeleniumTestCase {
    var $title = 'Login/Logout-Test';

    function setUp() {

    }

    function tearDown() {
    }

	function execute() {
		echo 'execute';
		$this->open('/');
		
		$this->type('name=data[User][email]', 'wrongemail');
		$this->type('name=data[User][password]', 'wrongpass');
		$this->clickAndWait('//button[@type=\'submit\']');
		$this->assertLocation('http://de.ekpenso.com/users/login');
		$this->assertTextPresent('Login');		
		
		$this->type('name=data[User][email]', 'mail@example.com');
		$this->type('name=data[User][password]', 'password');
		
		$this->clickAndWait('//button[@type=\'submit\']');
		$this->assertLocation('http://de.ekpenso.com/users/hello');
		$this->assertTextPresent('Logout');
		
		$this->clickAndWait('link=Logout');
		$this->assertLocation('http://de.ekpenso.com/');
		$this->assertTextPresent('Login');
	}
}