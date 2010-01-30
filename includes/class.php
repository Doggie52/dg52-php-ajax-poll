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
	require('includes/config.php');
		
	mysql_connect($config['dbHost'], $config['dbUser'], $config['dbPassw']) or die(mysql_error());
		mysql_select_db($config['dbName']) or die(mysql_error());
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

?>