<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

function secure($string) {
	$string = strip_tags($string);
	$string = htmlspecialchars($string);
	$string = trim($string);
	$string = stripslashes($string);
	$string = mysql_real_escape_string($string);
	return $string;
}

function incFile($filename) {
	// Get the extension
	$filename = strtolower($filename);
	$exts = split("[/\\.]", $filename);
	$n = count($exts)-1;
	$exts = $exts[$n];
	
		// Return different depending on the extension
		if ($exts=="css"){
			return "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$filename."\" />";
		}elseif ($exts=="js"){
			return "<script type=\"text/javascript\" src=\"".$filename."\"></script>";
		}elseif ($exts=="txt"){
			$myFile = $filename;
			$fopen = fopen($myFile, 'r');
			$output = fread($fopen, filesize($myFile));
			fclose($fopen);
			return $output;
		}
}

// Database class
class DB {
	
	// Connect or die
	function connect() {

	// Include database-config
	include('includes/config.php');
		
		// Set vars
		$this->dbHost 		= $config['dbHost'];
		$this->dbUser 		= $config['dbUser'];
		$this->dbPassword 	= $config['dbPassw'];
		$this->dbName 		= $config['dbName'];
		
		mysql_connect($this->dbHost, $this->dbUser, $this->dbPassword) or die(mysql_error());
		mysql_select_db($this->dbName) or die(mysql_error());
	}
	
	// Close the connection
	function close() {
		mysql_close();
	}
	
	// A normal query, for DELETE and UPDATE along with other stuff
	function query($sql) {
		$query = mysql_query($sql);
	}
	
	// Fetch results from SELECT
	function fetch($sql) {
		$query = mysql_query($sql);
		$array = mysql_fetch_array($query);
		return $array;
	}
}

class poll extends DB {

	// Define vars
	var $handled;
	
	// Displays the default poll
	function displayPoll() {
		// Fetch the poll
		$question = $this->fetch("SELECT * FROM `questions` WHERE `show` = '1' LIMIT 1");
		// Fetch the answers
		$answer = $this->fetch("SELECT * FROM `results` WHERE `id` = '".$question['id']."'");
		
			// Do the math to get the percentage
			$a1 = 100*@round($answer['a1']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$a2 = 100*@round($answer['a2']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$a3 = 100*@round($answer['a3']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$a4 = 100*@round($answer['a4']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$a5 = 100*@round($answer['a5']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			
				// Echo poll header
				echo "<h2>Results of \"".$question['question']."\"</h2>";
					// Print a default output scheme
					echo "<ul>";
					echo "<li>".$question['a1']." - ".$a1."%</li>";
					echo "<li>".$question['a2']." - ".$a2."%</li>";
					  if ($question['a3']){
					  echo "<li>".$question['a3']." - ".$a3."%</li>";
					  }
					  if ($question['a4']){
					  echo "<li>".$question['a4']." - ".$a4."%</li>";
					  }
					  if ($question['a5']){
					  echo "<li>".$question['a5']." - ".$a5."%</li>";
					  }
					echo "</ul>";
					echo "<p>You can revote after 24 hours!</p>";
	}
	
	// Displays the voting module
	function displayVote() {
		// Fetch the questions
		$questions = $this->fetch("SELECT * FROM `questions` WHERE `show` = '1' LIMIT 1");
			
			// Echo poll header
			echo "<h2>".$questions['question']."</h2>";
			
				// Start the form
				echo "<form>";
				echo "<p>";
				echo "<input type=\"hidden\" id=\"id\" value=\"".$questions['id']."\" />";
				echo "<select id=\"vote\">";
				echo "<option value=\"a1\">".$questions['a1']."</option>";
				echo "<option value=\"a2\">".$questions['a2']."</option>";
				  if ($questions['a3']){
				  echo "<option value=\"a3\">".$questions['a3']."</option>";
				  }
				  if ($questions['a4']){
				  echo "<option value=\"a4\">".$questions['a4']."</option>";
				  }
				  if ($questions['a5']){
				  echo "<option value=\"a5\">".$questions['a5']."</option>";
				  }
				echo "</select>";
				echo "<input type=\"button\" onclick=\"placeVote()\" value=\"Vote\" />";
				echo "</p></form>";
			// Print the result container
			echo "<div id=\"resultDiv\"><p>Results</p></div>";
	}
	
	// Processes the vote
	function votePoll($answer_column, $question_id) {
		// Check for a cookie
		if ($_COOKIE['voted']==1){
		  echo "<p>You have already voted within the past 24 hours!</p>";
		}else{
		// The cookie is not set, continue
		
			// Check for invalid stuff
			$answer_array = array("a1", "a2", "a3", "a4", "a5");
			if (!in_array($answer_column, $answer_array)){
			  echo("<p>Invalid answer!</p>");
			}else{
			// The answername is there, continue
			
				// Check current number of votes
				$vote_array = $this->fetch("SELECT `".$answer_column."` FROM `results` WHERE `id` = '".$question_id."'");
				$numvotes = $vote_array[$answer_column];
				
					// Do the maths
					if (!$numvotes){
					$numvotes = "1";
					}else{
					$numvotes = ++$numvotes;
					}
				  
				// Update the database
				$this->query("UPDATE `results` SET `".$answer_column."` = '".$numvotes."' WHERE `id` = '".$question_id."'");
				// Set a cookie
				setcookie("voted", "1", time()+86400);
				// And last but not least, return a handled variable since it was a valid vote
				$this->handled = 1;
			}
		}
	}

}

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