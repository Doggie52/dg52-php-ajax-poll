<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

	// Declare array
	$config = array();

	// Values corresponding to the database
	// Edit these to reflect your own environment
	$config['dbHost']	= "localhost";
	$config['dbPort']	= '3306';
	$config['dbName']	= "database";
	$config['dbUser']	= "username";
	$config['dbPassw']	= "password";
	
	// The location of your root directory, system directory and themes directory
	define("POLL_BASE_DIR", 	$_SERVER['DOCUMENT_ROOT']."/");
	define("POLL_SYS_DIR", 		$_SERVER['DOCUMENT_ROOT']."/system/");
	define("POLL_THEME_DIR", 	$_SERVER['DOCUMENT_ROOT']."/themes/");
	
	// Turn the debug-feature on or off (TRUE or FALSE)
	// The debug-feature spews info about SQL queries and disables cookies after voting
	define("POLL_DEBUG", 		FALSE);

?>