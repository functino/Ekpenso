<?php
include('conversion_interface.php');
include('ekpenso2freemind.php');
include('freemind2ekpenso.php');

class Converter 
{
	var $converter;
	
	function __construct($type = null)
	{
		if($type != null)
		{
			$this->load($type);
		}
	}
	function load($type)
	{	
		$converter = null;
		switch($type)
		{
			case 'ekpenso2freemind':
				$converter = new Ekpenso2Freemind();
			break;
			case 'freemind2ekpenso':
				$converter = new Freemind2Ekpenso();
			break;
			default:
				echo 'Warning: Converter '.$type.' not found.';
		}
		
		$this->converter = $converter;
	}
	
	function convert($string)
	{
		if($this->converter != null)
		{
			return $this->converter->convert($string);	
		}
		else
		{
			echo 'Warning: No Converter choosen';
		}
	}
}