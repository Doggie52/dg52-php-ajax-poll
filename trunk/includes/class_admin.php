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
		if($_SESSION['adminKey']==md5($_SERVER['REMOTE_ADDR']."salt")){
			$this->adminKey = TRUE;
		}else{
			$this->adminKey = FALSE;
		}
	}
	
	// Unset the adminkey
	function loseSession(){
		unset($_SESSION['adminKey']);
	}
	
	// Display the login-form
	function formLogin($action){
		echo "<form name=\"login\" id=\"login\" method=\"POST\" action=\"".$action."\">";
		echo "<p>Username: <input type=\"text\" name=\"username\" /></p>";
		echo "<p>Password: <input type=\"password\" name=\"password\" /></p>";
		echo "<p><input type=\"submit\" value=\"Log-in\" name=\"login\" /></p>";
		echo "</form>";
	}
	
	// Handle the log-in:ing
	function handleLogin(){
		// Has the form been processed?
		if($_POST['login']){
			// Yes, it has, continue
			
			// Get username and password, hashed, from the database
			$adminDetails = $this->fetch("SELECT `username`, `password` FROM `admin`");
				// Check if these are identical to the input
				if ($adminDetails['username']==md5($_POST['username'])){
					if ($adminDetails['password']==md5($_POST['password'])){
						// They are, so set a session
						$this->setSession();
					}
				}
		}
	}
}

class admin extends DB{

	// Displays the form for various things
	function form($type, $id){
		switch($type){
		case "add":
			// Initialize the add-form
			echo "<form name=\"add\" action=\"admin.php?handle=".$type."\">";
			echo "<p>Poll header: <input type=\"text\" name=\"header\" /></p>";
			echo "<p>First question: <input type\"text\" name=\"a1\" /></p>";
			echo "<p>Second question: <input type=\"text\" name=\"a2\" /></p>";
			echo "<p>Third question: <input type=\"text\" name=\"a3\" /></p>";
			echo "<p>Fourth question: <input type=\"text\" name=\"a4\" /></p>";
			echo "<p>Fifth question: <input type=\"text\" name=\"a5\" /></p>";
			echo "<p><input type=\"submit\" value=\"Add poll\" name=\"submit\" /></p>";
			echo "</form>";
		break;
		case "edit":
			if($id){
				// Fetch the values in the database matching $id
				$questions = $this->fetch("SELECT * FROM `questions` WHERE `id` = '".$id."");
				// Initialize the edit-form
				echo "<form name=\"edit\" action=\"admin.php?handle=".$type."&id=".$id."\">";
				echo "<p>Poll header: <input type=\"text\" name=\"question\" value=\"".$questions['question']."\" /></p>";
				echo "<p>First question: <input type\"text\" name=\"a1\" value=\"".$questions['a1']."\" /></p>";
				echo "<p>Second question: <input type=\"text\" name=\"a2\" value=\"".$questions['a2']."\" /></p>";
				echo "<p>Third question: <input type=\"text\" name=\"a3\" value=\"".$questions['a3']."\" /></p>";
				echo "<p>Fourth question: <input type=\"text\" name=\"a4\" value=\"".$questions['a4']."\" /></p>";
				echo "<p>Fifth question: <input type=\"text\" name=\"a5\" value=\"".$questions['a5']."\" /></p>";
				echo "<p><input type=\"submit\" value=\"Edit poll\" name=\"submit\" /></p>";
			}
		break;
		case "delete":
			if($id){
				// Fetch the values in the database matching $id
				$poll = $this->fetch("SELECT * FROM `questions` WHERE `id` = '".$id."");
				// Initialize the confirmation question
				echo "<form name=\"confirm_delete\" action=\"admin.php?handle=".$type."&id=".$id."\">";
				echo "<p>Are you sure you want to delete the \"".$poll['question']."\" poll?</p>";
				echo "<p><select id=\"delete\" name=\"delete\"><option value=\"1\">Yes</option><option value=\"0\">No</option></select></p>";
				echo "<p><input type=\"submit\" value=\"Delete\" name=\"submit\" /></p>";
				echo "</form>";
			}
		break;
		default:
			echo "<p>Something went wrong!</p>";
		}
	}
	
	// Handles the form-input
	function handle($type, $id){
		switch($type){
		case "add":
			// Make sure the form has been submitted with necessary values
			if($_POST['submit']&&$_POST['question']&&$_POST['a1']&&$_POST['a2']){
				// Add a row to the questions and an empty row to the results
				$this->query("INSERT INTO `questions` (question, a1, a2, a3, a4, a5) VALUES ('".$_POST['question']."', '".$_POST['a1']."', '".$_POST['a2']."', '".$_POST['a3']."', '".$_POST['a4']."', '".$_POST['a5']."')");
				$this->query("INSERT INTO `results` (a1, a2, a3, a4, a5) VALUES ('0', '0', '0', '0', '0')");
			}else{
				// Output an error
				echo "<p>Something was missing or went wrong!</p>";
			}
		break;
		case "edit":
		if($id){
			// Make sure the form has been submitted with necessary values
			if($_POST['submit']){
				// Update the row
				$this->query("UPDATE `questions` (question, a1, a2, a3, a4, a5) VALUES ('".$_POST['question']."', '".$_POST['a1']."', '".$_POST['a2']."', '".$_POST['a3']."', '".$_POST['a4']."', '".$_POST['a5']."') WHERE `id` = '".$id."'");
			}else{
				// Output an error
				echo "<p>Something was missing or went wrong!</p>";
			}
		}
		break;
		case "delete":
		if($id){
			// Make sure "delete" was set to 1 (yes)
			if($_POST['submit']){
				if($_POST['delete']==1){
					// Delete the row
					$this->query("DELETE * FROM `questions` WHERE `id` = '".$id."'");
				}else{
					// Output an "error"
					echo "<p>Post was not deleted.</p>";
				}
			}else{
				// Output an error
				echo "<p>Something was missing or went wrong!</p>";
			}
		}
		break;
		default:
			echo "<p>Something went wrong!</p>";
		}
	}
}

?>