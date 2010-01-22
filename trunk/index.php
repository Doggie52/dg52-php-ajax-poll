<?php

// Includes
include("includes/class.php");

	// Creates the DB connection
	$DB = new DB();
	$DB->connect();
	  
	// Creates the default poll
	$poll = new poll();
  
		// Output the HTML header and add the CSS, java and title
		$outputHeader = incFile("includes/header.txt");
		$outputHeader = ereg_replace("%TITLE%", "Poll Home", $outputHeader);
		$outputHeader = ereg_replace("%CSS%", incFile("includes/styles.css"), $outputHeader);
		$outputHeader = ereg_replace("%JAVASCRIPT%", incFile("ajax.js"), $outputHeader);
		echo $outputHeader;
	  
			// Displays the polls and vote-options
			$poll->displayVote();
		  
		// Output the HTML footer
		echo incFile("includes/footer.txt");

	// Closes the connection
	$DB->close();
  
?>