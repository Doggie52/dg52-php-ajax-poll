<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

class session extends DB
{

	// Define vars
	var $adminKey;
	
	// The constructor which starts a session
	function session()
	{
		session_start();
	}
	
	// Set the valid adminkey
	function setSession()
	{
		$_SESSION['adminKey'] = md5($_SERVER['REMOTE_ADDR']."salt");
	}
	
	// Check if a valid adminkey is present
	function checkSession()
	{
		if($_SESSION['adminKey'] == md5($_SERVER['REMOTE_ADDR']."salt")){
			$this->adminKey = TRUE;
		}
		else
		{
			$this->adminKey = FALSE;
		}
	}
	
	// Unset the adminkey
	function loseSession()
	{
		unset($_SESSION['adminKey']);
		return 1;
	}
	
	// Handle the log-in:ing
	function handleLogin()
	{
		// Has the form been processed?
		if($_POST['login'])
		{
			// Yes, it has, continue
			
			// Get username and password, hashed, from the database
			$adminDetails = $this->fetch("SELECT `username`, `password` FROM `admin`");
				// Check if these are identical to the input
				if($adminDetails['username'] == md5($_POST['username'])
					&&
					$adminDetails['password'] == md5($_POST['password']))
				{
					// They are, so set a session
					$this->setSession();
				}
				else
				{
					echo "<div id=\"error\"><p>Incorrect username or password!</p></div>";
				}
		}
	}
}

class admin extends DB
{

	// Displays the form for various things
	function form($type, $id = NULL)
	{
		switch($type)
		{
		case "add":
			// Make $template object global
			global $template;
				// Initialize the add-form
				$template->printTemplate("admin/addform");
		break;
		case "list":
			// Fetch the polls
			$query = $this->query("SELECT * FROM `questions`");
			// Make $template object global
			global $template;
			// Start the list
			echo "<ul>\n";
			// For every poll question show a row
			while($poll = $this->fetch_array($query))
			{
				$template->printTemplate("admin/pollrow", $poll);
			}
			// End the list
			echo "\n</ul>";
		break;
		case "edit":
			if($id)
			{
				// Fetch the values in the database matching $id
				$questions = $this->fetch("SELECT * FROM `questions` WHERE `id` = ".$id."");
				// Initialize the edit-form
				echo "<form name=\"edit\" action=\"index.php?handle=edit&id=".$id."\">";
				// Make $template object global and print edit form
				global $template;
					$template->printTemplate("admin/editform", $questions);
				echo "</form>";
			}
		break;
		case "delete":
			if($id)
			{
				// Fetch the values in the database matching $id
				$poll = $this->fetch("SELECT `question` FROM `questions` WHERE `id` = ".$id."");
				// Initialize the confirmation question
				echo "<form name=\"confirm_delete\" method=\"post\" action=\"admin.php?handle=delete&id=".$id."\">";
				// Make $template object global and print delete form
				global $template;
					$template->printTemplate("admin/deleteform", $poll);
				echo "</form>";
			}
		break;
		default:
			echo "<div id=\"error\"><p>Missing type-variable!</p></div>";
		}
	}
	
	// Handles the form-input
	function handle($type, $id = NULL)
	{
		switch($type)
		{
		case "add":
			// Make sure the form has been submitted with necessary values
			if($_POST['submit'] && $_POST['question'] && $_POST['a1'] && $_POST['a2'])
			{
				// Add a row to the questions and an empty row to the results
				$this->query("
					INSERT INTO `questions`
						(`show`, `question`, `a1`, `a2`, `a3`, `a4`, `a5`)
					VALUES (
						'".$_POST['show']."',
						'".$_POST['question']."',
						'".$_POST['a1']."',
						'".$_POST['a2']."',
						'".$_POST['a3']."',
						'".$_POST['a4']."',
						'".$_POST['a5']."'
					)
				");
				$this->query("INSERT INTO `results` (a1, a2, a3, a4, a5) VALUES (0, 0, 0, 0, 0)");
				// Output success
				echo "<p>Poll was successfully added!</p>";
			}
			else
			{
				// Output an error
				echo "<div id=\"error\"><p>Form was not submitted!</p></div>";
			}
		break;
		case "edit":
			if($id)
			{
				// Make sure the form has been submitted with necessary values
				if($_POST['submit'] && $_POST['question'] && $_POST['a1'] && $_POST['a2'])
				{
					// Update the row
					$this->query("
						UPDATE `questions`
							(question, a1, a2, a3, a4, a5)
						VALUES (
							'".$_POST['question']."',
							'".$_POST['a1']."',
							'".$_POST['a2']."',
							'".$_POST['a3']."',
							'".$_POST['a4']."',
							'".$_POST['a5']."'
						)
						WHERE `id` = ".$id."
					");
					// Output success
					echo "<p>Poll was successfully edited!</p>";
				}
				else
				{
					// Output an error
					echo "<div id=\"error\"><p>Form was not submitted!</p></div>";
				}
			}
		break;
		case "show":
			// Make sure the form has been submitted with the necessary ID
			if($id)
			{
				// Select the poll that previously was shown
				$oldshow = "SELECT `id` FROM `questions` WHERE `show` = 1";
				$oldquery = $this->query($oldshow);
				// If there actually are any shown polls
				if(!empty($oldquery))
				{
					while($oldfetch = $this->fetch_array($oldquery))
					{
						// Hide each shown poll
						// There should be only one, but just in case there are more we hide all of them
						$hideold = "UPDATE `questions` SET `show` = 0 WHERE `id` = ".$oldfetch['id']."";
						$hideoldquery = $this->query($hideold);
					}
				}
				
				// Show the new poll selected by the user
				$newshow = "UPDATE `questions` SET `show` = 1 WHERE `id` = ".$id."";
				$newquery = $this->query($newshow);
				
				// Output success
				echo "<p>Poll was successfully set as the main poll!</p>";
			}
		break;
		case "delete":
			if($id)
			{
				// Make sure the button was pressed
				if($_POST['submit'])
				{
					// Delete the row
					$this->query("DELETE * FROM `questions` WHERE `id` = ".$id."");
					// Echo output
					echo "<p>Poll question (ID <code>$id</code>) was successfully deleted!</p>";
				}
				else
				{
					// Output an error
					echo "<div id=\"error\"><p>Form was not submitted!</p></div>";
				}
			}
		break;

		default:
			echo "<div id=\"error\"><p>Missing handle-variable!</p></div>";
		}
	}
}

?>