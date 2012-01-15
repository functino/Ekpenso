<?php
class Tag extends AppModel {

	var $name = 'Tag';
	
	var $belongsTo = array(
			'User'
	);

	var $hasAndBelongsToMany = array(
			'Mindmap'
	);
	

	
}
