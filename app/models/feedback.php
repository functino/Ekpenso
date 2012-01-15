<?php
class Feedback extends AppModel {

	var $name = 'Feedback';
	var $useTable = 'feedback';

	var $validate = array(
	        'name' => array( 
	            'required' => array(
								'rule'=>VALID_NOT_EMPTY, 
								'message'=>'error.Feedback.name.required'),
	        ),
	        'body' => array(
	            'required' => array(
								'rule'=>VALID_NOT_EMPTY, 
								'message'=>'error.Feedback.body.required'),
	            'length' => array(
								'rule'=>'#.{5,}#', 
								'message'=>'error.Feedback.body.length'),
			),
	    ); 
}
?>
