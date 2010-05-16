<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

// A separate file for handling the displaying of various forms related to the polls, for use together with AJAX

// Require these only if the file is being loaded on its own
require_once("../config.php");
require_once(POLL_SYS_DIR."includes/class.php");
require_once(POLL_ADM_DIR."includes/class_admin.php");
require_once(POLL_SYS_DIR."includes/class_template.php");

switch($display)
{
	case "add":
		$admin->form("add");
	break;
	case "list":
		$admin->form("list");
	break;
	case "edit":
		$admin->form("edit", $id);
	break;
	case "delete":
		$admin->form("delete", $id);
	break;
	default:
		echo "<p>Undefined display variable!</p>";
}
?>