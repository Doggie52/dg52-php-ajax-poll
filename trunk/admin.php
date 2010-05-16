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
				if($session->adminKey==FALSE)
				{
						// Output the header template
						$template->printTemplate("admin/header");
						
						// Output the login-form
						$template->printTemplate("admin/loginform");
						
						// Output the footer template
						$template->printTemplate("admin/footer");
					exit;
				}
				else
				{
					// A not so user-friendly way of redirecting to the admin CP
					header("Location: /admin/index.php");
				}
?>