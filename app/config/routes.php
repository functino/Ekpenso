<?php
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	
	
	Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));
	Router::connect('/help', array('controller' => 'pages', 'action' => 'help'));
	Router::connect('/downloads', array('controller' => 'pages', 'action' => 'downloads'));
	Router::connect('/download/*', array('controller' => 'pages', 'action' => 'download'));
	
	Router::connect('/selenium/*', array('controller' => 'selenium', 'action' => 'display'));