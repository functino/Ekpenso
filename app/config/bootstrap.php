<?php


// base domain of the application
// languag specific urls will add a en., de. or [lang]. subdomain
Configure::write('base_url', 'example.com');

// Session-Cookie has to be present in all subdomains, to stay logged in on language changes...
Configure::write('Session.domain', '.'.Configure::read('base_url'));

//email-configuration
Configure::write('Email.delivery', 'smtp'); //debug or smtp, in debug-mode no emails are sent.
Configure::write('Email.from', '<support@example.com>');

// these account is used to send the mails
Configure::write('Email.smtpOptions', array(
							 'port'=> 25,
							 'host' => 'smtp.example.com',
							 'timeout' => 30,
							 'username' => 'support@example.com',
							 'password' => ''
							 ));


//if the viewer-version changes we rename it to avoid problems with browser-caches
// here we specify the name.
Configure::write('Viewer.name', 'viewer44.swf');				 

// langaues is an array of supported languages, language files for each language are located under for example:
// app/locale/deu/LC_MESSAGES/default.po
$languages = array(
	//code is used as prefix in the url, example: http://en.xample.com/controller/action
	//locale relates to the language and the path in app/locale, example: app/locale/eng
	//text is used in the views to display a link to switch the language
	array('code'=>'en', 'locale'=>'eng', 'text'=>'english'),
	array('code'=>'de', 'locale'=>'deu', 'text'=>'deutsch'),
	//array('code'=>'fr', 'locale'=>'fre', 'text'=>'francais'),
);
Configure::write('languages', $languages);

//specify the default language
Configure::write('Config.language', 'de');


// parse URL to get the language...
$host = env('HTTP_HOST');
$subdomain = substr($host, 0, strpos($host, '.'));
foreach($languages as $lang)
{
	if ($subdomain == $lang['code']) {
		Configure::write('Config.language', $lang['code']);
	}
}






 /**
 * Convenience function for date formatting
 *
 * @param string $format a valid date-format for date()
 * @param string $date	a string that can be parsed by strtotime()
 * @return mixed false if $date is null or 0000-00-00, a string with the formated date otherwise
 */
function d($format, $date)
{
	// check if the given date is null or 0000-00-00 
	if($date != null and $date!='0000-00-00')
	{
		$time = strtotime($date);
		return date($format, $time);
	}
	else
	{
		return false;
	}
}