<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// Includes
include("config.php");
include(POLL_SYS_DIR."includes/class.php");
include(POLL_SYS_DIR."includes/class_template.php");

	// Creates the DB connection
	$DB = new DB();
	
		// Creates the default poll
		$poll = new poll();
		
		// Creates the template parser
		$template = new template();
	
			// Output the header template
			$template->printTemplate("header");
		
				// Displays the polls and vote-options
				$poll->displayVote();
			
			// Output the footer template
			$template->printTemplate("footer");

?>