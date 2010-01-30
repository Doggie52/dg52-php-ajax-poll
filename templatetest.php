<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// Test file for templates

	// include
	include("includes/class.php");
	include("includes/class_template.php");
	
		// new object
		$template = new template();
		
			// output
			$template->printTemplate("test");

?>