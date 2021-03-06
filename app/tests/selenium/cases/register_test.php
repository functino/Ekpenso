<?php
class RegisterTest extends SeleniumTestCase {
    var $title = 'Registrierung-Test';

    function setUp() {
    }

    function tearDown() {
    	// Delete the created user so the next test can run...
    	App::import('Model', 'User');
    	$user = new User();
    	$res = $user->findByUsername('username3');
    	if($res)
    	{
			$user->del($res['User']['id']);	
		}
    }

	function execute() {
		$this->open('/');
		$this->clickAndWait('link=Anmelden');
		$this->type('id=UserUsername','username');
		$this->type('id=UserEmail','mail@example.com');
		$this->type('id=UserPassword','password');
		$this->clickAndWait('//button[@type=\'submit\']');
		$this->assertTextPresent('Bitte korrigiere');
		$this->assertTextPresent('Dieser Name wird schon verwendet.');
		$this->assertTextPresent('Diese Email-Adresse wird schon verwendet!');
		
		$this->type('id=UserUsername','username3');
		$this->type('id=UserEmail','mail3@example.com');
		$this->type('id=UserPassword','password3');
		$this->clickAndWait('//button[@type=\'submit\']');
		
		
		$this->assertTextPresent('Anmeldung abgeschlossen.');
		$this->assertTextPresent('Logout');
		$this->clickAndWait('link=Logout');
	}
}