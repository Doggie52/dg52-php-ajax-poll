<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

	// Declare array
	$config = array();

	// Set these values to your own
	$config['dbHost']	= "sql203.byethost9.com";
	$config['dbPort']	= '3306';
	$config['dbName']	= "b9_5389139_poll";
	$config['dbUser']	= "b9_5389139";
	$config['dbPassw']	= "Vista123";
	
	define("POLL_BASE_DIR", $_SERVER['DOCUMENT_ROOT']."/");
	define("POLL_SYS_DIR", $_SERVER['DOCUMENT_ROOT']."/system/");
	define("POLL_THEME_DIR", $_SERVER['DOCUMENT_ROOT']."/themes/");

?>