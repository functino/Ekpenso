<?php
class FeedbackTest extends SeleniumTestCase {
	var $title = 'Feedback-Test';

	function execute() {
		
		//@TODO
		//assertions missing
		// ...
		
		$this->open('/');
		$this->click('//div[@id=\'overall\']/div[2]/b');
		$this->clickAndWait('//form[@id=\'feedback_form\']/table/tbody/tr[4]/td/button');
		$this->type('document.forms[2].elements[\'data[Feedback][name]\']','testname');
		$this->clickAndWait('//div[@id=\'content\']/form/table/tbody/tr[4]/td/button');
		$this->type('document.forms[2].elements[\'data[Feedback][name]\']');
		$this->type('document.forms[2].elements[\'data[Feedback][body]\']','test-text');
		$this->clickAndWait('//div[@id=\'content\']/form/table/tbody/tr[4]/td/button');
		$this->type('document.forms[2].elements[\'data[Feedback][name]\']','test-name');
		$this->clickAndWait('//div[@id=\'content\']/form/table/tbody/tr[4]/td/button');
		$this->click('//div[@id=\'overall\']/div[3]/b');
		$this->type('id=FeedbackName','test-text');
		$this->type('id=FeedbackBody','test-text');
		$this->clickAndWait('//form[@id=\'feedback_form\']/table/tbody/tr[4]/td/button');
		$this->clickAndWait('//div[@id=\'navigation_box\']/ul/li[4]/a/span');
		$this->clickAndWait('link=Feedback');
		$this->type('document.forms[2].elements[\'data[Feedback][name]\']','test-text');
		$this->type('document.forms[2].elements[\'data[Feedback][body]\']','test-name');
		$this->clickAndWait('//div[@id=\'content\']/form/table/tbody/tr[4]/td/button');
	}
}
?>