<?php

// Includes
include("includes/class.php");

	// Creates the DB connection
	$DB = new DB();
	$DB->connect();
      
		// Creates the default poll
		$poll = new poll();
  
			// Process the vote
			$poll->votePoll($_GET['vote'], $_GET['id']);
      
				// If the vote was valid, show results
				if ($poll->handled==1){
					$poll->displayPoll();
				}
  
?>