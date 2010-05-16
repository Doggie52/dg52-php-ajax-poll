<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// Requirements
require("config.php");
require(POLL_SYS_DIR."includes/class.php");
require(POLL_SYS_DIR."includes/class_template.php");

	// Creates the DB connection
	$DB = new DB();
	
		// Creates the template parser
		$template = new template();

		// Creates the default poll
		$poll = new poll();

			// Process the vote
			$poll->votePoll($_GET['vote'], $_GET['id']);

				// If the vote was valid, show results
				if ($poll->handled==1)
				{
					$poll->displayPoll();
				}

?>