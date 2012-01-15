<?php 
//read all supported languages
$langs = Configure::read('languages');
foreach($langs as $lang){
	//list all languages (ecxept the current choosen one)
	if(Configure::read('Config.language') != $lang['code'])
	{
		//construct url 
		$url = 'http://' . $lang['code'] . '.'.Configure::read('base_url').$_SERVER['REQUEST_URI'];
		$langArr[] = $html->link($lang['text'], $url);	
	}
}
echo implode(' | ', $langArr);