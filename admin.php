<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// Includes
include("includes/class.php");
include("includes/class_admin.php");

	// Creates the DB connection
	$DB = new DB();
	$DB->connect();
  
		// Creates the session
		$session = new session();
	
			// Handles the login
			$session->handleLogin();
	
				// Checks if a valid session is available
				$session->checkSession();
		
				// Shows the form if the adminkey is invalid
				if($session->adminKey==FALSE){
						// Output the HTML header and add the CSS, java and title
						$outputHeader = incFile("includes/header.txt");
						$outputHeader = ereg_replace("%TITLE%", "Poll Admin: Log In", $outputHeader);
						$outputHeader = ereg_replace("%CSS%", incFile("includes/styles.css"), $outputHeader);
						$outputHeader = ereg_replace("%JAVASCRIPT%", incFile("ajax.js"), $outputHeader);
							echo $outputHeader;
						$session->formLogin("admin.php");
						
						// Output the HTML footer
						echo incFile("includes/footer.txt");
					exit;
				}

	// Get the URL variables
	$display  = $_GET['display'];
	$handle	  = $_GET['handle'];
	$id		  = $_GET['id'];
	
		// Create the admin-object
		$admin = new admin();
		
		// Output the HTML header and add the CSS, java and title
		$outputHeader = incFile("includes/header.txt");
		$outputHeader = ereg_replace("%TITLE%", "Poll Administration: Home", $outputHeader);
		$outputHeader = ereg_replace("%CSS%", incFile("includes/styles.css"), $outputHeader);
		$outputHeader = ereg_replace("%JAVASCRIPT%", incFile("ajax.js"), $outputHeader);
			echo $outputHeader;
		// Output the adminpanel header
			echo "<h1>Welcome to the Control Panel!</h1>\n";
			echo "<small>The time is ".date(DATE_RFC822)." GMT.\n<br />\nYour adminkey for this IP: ".$_SESSION['adminKey']."</small>\n";
		// Output list of links	
			echo "<ul>\n
				<li><a href=\"admin.php\">Home</a></li>
				<li><a href=\"?display=add\">Add poll question</a></li>
				<li><a href=\"?display=edit?id=1\">Edit poll question</a></li>
				<li><a href=\"?display=delete?id=1\">Delete poll question</a></li>
				</ul>\n";

	
		// Start the displayswitch if the variable is available
		if($display){
			switch($display){
				case "add":
					$admin->form("add", '0');
				break;
				case "edit":
					$admin->form("edit", $id);
				break;
				case "delete":
					$admin->form("delete", $id);
				break;
				default:
					echo "<p>Something went wrong!</p>";
			}
		// Else if the handle variable is available start the handleswitch
		}elseif($handle){
			switch($handle){
				case "add":
					$admin->handle("add");
				break;
				case "edit":
					$admin->handle("edit", $id);
				break;
				case "delete":
					$admin->handle("delete", $id);
				break;
				default:
					echo "<p>Something went wrong!</p>";
			}
		// Else start the default adminmenu
		}else{

		}
		
		// Output the HTML footer
		echo incFile("includes/footer.txt");

	// Closes the connection
	$DB->close();

?>