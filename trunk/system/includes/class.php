<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/

function secure($string) {
	// Secures $string using various methods
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
		$string = trim($string);
		$string = stripslashes($string);
		$string = mysql_real_escape_string($string);
	return $string;
}

function incFile($filename) {
	// Includes a file based on its extension
		// Get the extension
		$filename = strtolower($filename);
		$exts = split("[/\\.]", $filename);
		$n = count($exts)-1;
		$exts = $exts[$n];
		
			// Return different depending on the extension
			if ($exts=="css"){
				return "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$filename."?sid=".md5(time())."\" />";
			}elseif ($exts=="js"){
				return "<script type=\"text/javascript\" src=\"".$filename."?sid=".md5(time())."\"></script>";
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
	
	// Class constructor - connect to the database
	function __construct() {
		global $config;
		mysql_connect(
			$config['dbHost'],
			$config['dbUser'],
			$config['dbPassw']
		) or die(mysql_error());
			mysql_select_db($config['dbName']) or die(mysql_error());
	}
	
	// A normal query, for DELETE and UPDATE along with other stuff
	function query($sql) {
		$query = mysql_query($sql) or die(mysql_error());
		
		if(POLL_DEBUG) {
			echo "<code>$query</code><br />";
		}
	}
	
	// Fetch results from SELECT
	function fetch($sql) {
		$query = mysql_query($sql) or die(mysql_error());
		$array = mysql_fetch_array($query);
		return $array;
		
		if(POLL_DEBUG) {
			echo "<code>$query</code><br />";
			echo "<code>".print_r($array)."</code><br />";
		}
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
			// Avoid possible warnings when dividing by zero
			$question['pcrta1'] = 100*@round($answer['a1']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$question['pcrta2'] = 100*@round($answer['a2']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$question['pcrta3'] = 100*@round($answer['a3']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$question['pcrta4'] = 100*@round($answer['a4']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			$question['pcrta5'] = 100*@round($answer['a5']/($answer['a1']+$answer['a2']+$answer['a3']+$answer['a4']+$answer['a5']),3);
			
			// If answer exists, display it
			if($answer['a3']) {
				$question['extra3'] = "block";
			}
			if($answer['a4']) {
				$question['extra4'] = "block";
			}
			if($answer['a5']) {
				$question['extra5'] = "block";
			}
			
				// Make $template object global and output results
				global $template;
					$template->printTemplate("results", $question);
	}
	
	// Displays the voting module
	function displayVote() {
		// Fetch the questions
		$questions = $this->fetch("SELECT * FROM `questions` WHERE `show` = '1' LIMIT 1");
			
			// Echo poll header
			echo "<h2>".$questions['question']."</h2>
			<div class=\"flower\">&nbsp;</div>";
			
				// Start the form
				echo "\n<form name=\"vote\">
				<p>
				<input type=\"hidden\" id=\"voteid\" value=\"".$questions['id']."\" />
				<p><input type=\"radio\" name=\"voteradio\" class=\"styled\" value=\"a1\" />".$questions['a1']."</p>
				<p><input type=\"radio\" name=\"voteradio\" class=\"styled\" value=\"a2\" />".$questions['a2']."</p>";
					// If extra answers are available, display
					// If a third answer is not available, the others aren't either
					if ($questions['a3']){
						echo "\n<p><input type=\"radio\" name=\"voteradio\" class=\"styled\" value=\"a3\" />".$questions['a3']."</p>";
						if ($questions['a4']){
							echo "\n<p><input type=\"radio\" name=\"voteradio\" class=\"styled\" value=\"a4\" />".$questions['a4']."</p>";
							if ($questions['a5']){
								echo "\n<p><input type=\"radio\" name=\"voteradio\" class=\"styled\" value=\"a5\" />".$questions['a5']."</p>";
							}
						}
					}
				echo "\n<input type=\"button\" onclick=\"placeVote()\" value=\"Vote\" />
				</form>";
			// Print the result container for future information
			echo "\n<div id=\"resultDiv\"></div>";
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
				// Set a cookie for 24hrs if debug is off
				if(!POLL_DEBUG) {
					setcookie("voted", "1", time()+86400);
				}
				// And last but not least, return a handled variable since it was a valid vote
				$this->handled = 1;
			}
		}
	}

}

?>