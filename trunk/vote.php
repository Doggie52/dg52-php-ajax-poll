<?php
/*******************************************************************************
	Filename				: vote.php

	Created					: 04 August 2008 (19:56:56)
	Created by				: Douglas Stridsberg

	Last Updated			: 08 August 2008 (14:13:07)
	Updated by				: Douglas Stridsberg

	QueryString Collection	: 
	Form Collection			: 
	Session Variables		: 
	Database Tables			: 
	Stored Procedures		: 
	Include Files			: includes/class.php

	Comments				: 
*******************************************************************************/	
?>
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