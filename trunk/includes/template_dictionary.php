<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

	// Declare dictionary array
	$dictionary = array(
		// Main translations
		"TITLE" => "dG52 PHP and AJAX Poll",
		"DATE" => date(DATE_RFC822),
		// HTML-includes
		"CSS" => incFile("includes/styles.css"),
		"JAVASCRIPT" => incFile("ajax.js"),
		// Session-related
		"ADMINKEY" => $_SESSION['adminKey'],
		
		// Misc translations
		"TEST" => "Test!"
	);

?>