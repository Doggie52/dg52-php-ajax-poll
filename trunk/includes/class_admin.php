<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

class session extends DB {

	// Define vars
	var $adminKey;
	
	// The constructor which starts a session
	function session(){
		session_start();
	}
	
	// Set the valid adminkey
	function setSession(){
		$_SESSION['adminKey'] = md5($_SERVER['REMOTE_ADDR']."salt");
	}
	
	// Check if a valid adminkey is present
	function checkSession(){
		if($_SESSION['adminKey'] == md5($_SERVER['REMOTE_ADDR']."salt")){
			$this->adminKey = TRUE;
		}else{
			$this->adminKey = FALSE;
		}
	}
	
	// Unset the adminkey
	function loseSession(){
		unset($_SESSION['adminKey']);
		return 1;
	}
	
	// Handle the log-in:ing
	function handleLogin(){
		// Has the form been processed?
		if($_POST['login']){
			// Yes, it has, continue
			
			// Get username and password, hashed, from the database
			$adminDetails = $this->fetch("SELECT `username`, `password` FROM `admin`");
				// Check if these are identical to the input
				if ($adminDetails['username'] == md5($_POST['username'])
					&&
					$adminDetails['password'] == md5($_POST['password'])
				){
					// They are, so set a session
					$this->setSession();
				}else{
					echo "<div id=\"error\"><p>Incorrect username or password!</p></div>";
				}
		}
	}
}

class admin extends DB {

	// Displays the form for various things
	function form($type, $id){
		switch($type){
		case "add":
			// Make $template object global
			global $template;
				// Initialize the add-form
				$template->printTemplate("admin/addform");
		break;
		case "edit":
			if($id){
				// Fetch the values in the database matching $id
				$questions = $this->fetch("SELECT * FROM `questions` WHERE `id` = '".$id."'");
				// Initialize the edit-form
				echo "<form name=\"edit\" action=\"admin.php?handle=".$type."&id=".$id."\">";
				// Make $template object global
				global $template;
					$template->printTemplate("admin/editform");
				echo "</form>";
			}
		break;
		case "delete":
			if($id){
				// Fetch the values in the database matching $id
				$poll = $this->fetch("SELECT * FROM `questions` WHERE `id` = '".$id."'");
				// Initialize the confirmation question
				echo "<form name=\"confirm_delete\" action=\"admin.php?handle=".$type."&id=".$id."\">";
				echo "<p>Are you sure you want to delete the \"".$poll['question']."\" poll?</p>";
				echo "<p><select id=\"delete\" name=\"delete\"><option value=\"1\">Yes</option><option value=\"0\">No</option></select></p>";
				echo "<p><input type=\"submit\" value=\"Delete\" name=\"submit\" /></p>";
				echo "</form>";
			}
		break;
		default:
			echo "<div id=\"error\"><p>Missing type-variable!</p></div>";
		}
	}
	
	// Handles the form-input
	function handle($type, $id){
		switch($type){
		case "add":
			// Make sure the form has been submitted with necessary values
			if($_POST['submit'] && $_POST['question'] && $_POST['a1'] && $_POST['a2']){
				// Add a row to the questions and an empty row to the results
				$this->query("
					INSERT INTO `questions`
						(question, a1, a2, a3, a4, a5)
					VALUES (
						'".$_POST['question']."',
						'".$_POST['a1']."',
						'".$_POST['a2']."',
						'".$_POST['a3']."',
						'".$_POST['a4']."',
						'".$_POST['a5']."'
					)
				");
				$this->query("INSERT INTO `results` (a1, a2, a3, a4, a5) VALUES ('0', '0', '0', '0', '0')");
			}else{
				// Output an error
				echo "<div id=\"error\"><p>Form was not submitted!</p></div>";
			}
		break;
		case "edit":
		if($id){
			// Make sure the form has been submitted with necessary values
			if($_POST['submit']){
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
					WHERE `id` = '".$id."'
				");
			}else{
				// Output an error
				echo "<div id=\"error\"><p>Form was not submitted!</p></div>";
			}
		}
		break;
		case "delete":
		if($id){
			// Make sure "delete" was set to 1 (yes)
			if($_POST['submit']){
				if($_POST['delete'] == 1){
					// Delete the row
					$this->query("DELETE * FROM `questions` WHERE `id` = '".$id."'");
				}else{
					// Output an "error"
					echo "<div id=\"error\"><p>Post was not deleted.</p></div>";
				}
			}else{
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