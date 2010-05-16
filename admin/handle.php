<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// A separate file for handling various functions related to the polls, for use together with AJAX

// Require these only if the file is being loaded on its own
require_once("../config.php");
require_once(POLL_SYS_DIR."includes/class.php");
require_once(POLL_ADM_DIR."includes/class_admin.php");
require_once(POLL_SYS_DIR."includes/class_template.php");

switch($handle)
{
	case "add":
		$admin->handle("add");
	break;
	case "edit":
		$admin->handle("edit", $id);
	break;
	case "show":
		$admin->handle("show", $id);
	break;
	case "delete":
		$admin->handle("delete", $id);
	break;
	case "logout":
		if($session->loseSession())
		{
			echo "<meta http-equiv=\"refresh\" content=\"2;url=".POLL_BASE_URL."admin.php\">";
			echo "<p>Successfully logged out!</p>";
		}
	break;
	default:
		echo "<p>Undefined handle variable!</p>";
}
?>