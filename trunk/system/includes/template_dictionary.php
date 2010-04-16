<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

	// Declare dictionary array
	
	// GUIDELINES
	// On a new line, type the %VARIABLE% (without the %%'s) you want to translate, an arrow (=>) and what it translates to.
	// Remember to not include a comma in the last translation!
	$dictionary = array(
	
		// Main translations
		"TITLE" 		=> "dG52 PHP and AJAX Poll",
		"DATE" 			=> date(DATE_RFC822),
		
		// HTML-includes
		"CSS" 			=> incFile("themes/styles.css"),
		"AJAX" 			=> incFile("ajax.js"),
		"JQUERY"		=> incFile("http://code.jquery.com/jquery-1.4.2.min.js"),
		"FORMJS" 		=> incFile("form.js"),
		
		// Session-related
		"ADMINKEY" 		=> $_SESSION['adminKey'],
		
		// Dynamic form entries
		"QUESTION"		=> $additionalArray['question'],
		"ANSWER1"		=> $additionalArray['a1'],
		"ANSWER2"		=> $additionalArray['a2'],
		"ANSWER3"		=> $additionalArray['a3'],
		"ANSWER4"		=> $additionalArray['a4'],
		"ANSWER5"		=> $additionalArray['a5']
			
	);

?>