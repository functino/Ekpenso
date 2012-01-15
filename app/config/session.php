<?php 
/* This is my configuration file for session-management
* it is used/included in cake/libs/session.php
* see also app/config/core.php where this file is referenced...
*/
if (!isset($_SESSION)) {
	if (function_exists('ini_set')) {
		ini_set('session.use_trans_sid',0); //don't use trans_sid (we want no session-ids in urls)
		ini_set('session.name', Configure::read('Session.cookie')); // the name of our Session-cookie...
		ini_set('session.cookie_lifetime', 0); // it's a session-cookie so delete it when the browser closes
		ini_set('session.cookie_path', $this->path);
		ini_set('session.cookie_domain', Configure::read('Session.domain'));
	}
}