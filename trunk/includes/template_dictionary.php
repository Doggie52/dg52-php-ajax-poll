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
		"TITLE" 		=> "dG52 PHP and AJAX Poll",
		"DATE" 			=> date(DATE_RFC822),
		
		// HTML-includes
		"CSS" 			=> incFile("includes/styles.css"),
		"AJAX" 			=> incFile("ajax.js"),
		"FORMJS" 		=> incFile("form.js"),
		
		// Session-related
		"ADMINKEY" 		=> $_SESSION['adminKey'],
		
		// Dynamic form entries
		"QUESTION"		=> $questions['question'],
		"ANSWER1"		=> $questions['a1'],
		"ANSWER2"		=> $questions['a2'],
		"ANSWER3"		=> $questions['a3'],
		"ANSWER4"		=> $questions['a4'],
		"ANSWER5"		=> $questions['a5'],
		
	);

?>