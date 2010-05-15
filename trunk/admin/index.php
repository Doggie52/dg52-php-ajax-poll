<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// Requirements
require("../config.php");
require(POLL_SYS_DIR."includes/class.php");
require(POLL_ADM_DIR."includes/class_admin.php");
require(POLL_SYS_DIR."includes/class_template.php");

	// Creates the DB connection
	$DB = new DB();
	
		// Creates the template parser
		$template = new template();

		// Creates the session
		$session = new session();
	
			// Handles the login
			$session->handleLogin();
	
				// Checks if a valid session is available
				$session->checkSession();
		
				// Shows the form if the adminkey is invalid
				if($session->adminKey==FALSE){
						// Output the header template
						$template->printTemplate("admin/header");
						
						// Output the login-form
						$template->printTemplate("admin/loginform");
						
						// Output the footer template
						$template->printTemplate("admin/footer");
					exit;
				}

	// Get the URL variables
	$display  = $_GET['display'];
	$handle	  = $_GET['handle'];
	$id		  = $_GET['id'];
	
		// Create the admin-object
		$admin = new admin();
		
			// Output the header template
			$template->printTemplate("admin/header");
						
			// Output the adminpanel header
			$template->printTemplate("admin/panelheader");
	
		// Include the display-file if the display variable is available
		if($display) {
			include("display.php");
		// Else if the handle variable is available include the handle-file
		} elseif($handle) {
			include("handle.php");
		}
		
	// Output the footer template
	$template->printTemplate("admin/footer");

?>