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
		"CSS" 			=> incFile(POLL_BASE_URL."themes/styles.css"),
		"AJAX" 			=> incFile(POLL_BASE_URL."themes/js/ajax.js"),
		"JQUERY"		=> incFile("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"),
		"JQUERYUI"		=> incFile("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"),
		"EFFECTS"		=> incFile(POLL_BASE_URL."themes/js/effects.js"),
		"FORMJS" 		=> incFile(POLL_BASE_URL."themes/js/form.js"),
		"UNIFORM_JS"	=> incFile(POLL_BASE_URL."themes/js/jquery.uniform.min.js"),
		"UNIFORM_CSS"	=> incFile(POLL_BASE_URL."themes/uniform.default.css"),
		
		// Session-related
		"ADMINKEY" 		=> $_SESSION['adminKey'],
		
		// Dynamic form entries
		"QUESTIONID"	=> $additionalArray['id'],
		"QUESTION"		=> $additionalArray['question'],
		"SHOW"			=> "&nbsp;&nbsp;",
		"ANSWER1"		=> $additionalArray['a1'],
		"ANSWER2"		=> $additionalArray['a2'],
		"ANSWER3"		=> $additionalArray['a3'],
		"ANSWER4"		=> $additionalArray['a4'],
		"ANSWER5"		=> $additionalArray['a5'],
		"ANSWERPCRT1"	=> $additionalArray['pcrta1'],
		"ANSWERPCRT2"	=> $additionalArray['pcrta2'],
		"ANSWERPCRT3"	=> $additionalArray['pcrta3'],
		"ANSWERPCRT4"	=> $additionalArray['pcrta4'],
		"ANSWERPCRT5"	=> $additionalArray['pcrta5'],
			
	);
	
	// In order for the list of poll questions show which one is shown, the following must be set
	if($additionalArray['show'])
	{
		$dictionary['SHOW'] = "X";
	}
	
	// In order for the poll answers that aren't available to not show, the following must be set
	if(!$additionalArray['extra3'])
	{
		$dictionary['EXTRAANSWER3']	= "none";
	}
	else
	{
		$dictionary['EXTRAANSWER3']	= $additionalArray['extra3'];
	}
	
	if(!$additionalArray['extra4'])
	{
		$dictionary['EXTRAANSWER4']	= "none";
	}
	else
	{
		$dictionary['EXTRAANSWER4']	= $additionalArray['extra4'];
	}
	
	if(!$additionalArray['extra5'])
	{
		$dictionary['EXTRAANSWER5']	= "none";
	}
	else
	{
		$dictionary['EXTRAANSWER5']	= $additionalArray['extra5'];
	}

?>