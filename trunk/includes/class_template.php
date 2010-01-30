<?php

class template {

	function __construct(){
		// Checks for the 'templates'-folder's existence
		if(!file_exists("templates")){
			echo "Fatal error!
			<code>templates</code> directory does not exist!";
			exit;
		}
	}
	
	private function checkExist($templateName){
	// Checks a $templateName's existence - exit if non-existant
	}
	
	private function loadTemplate($templateName){
	// Loads $templateName
	}
	
	private function replaceTemplateVars($templateName, $dictionary){
	// Replaces variables in $templateName with those found in $dictionary
	}
	
	private function outputTemplate($templateName){
	// Outputs the given $templateName with the exchanged variables
	}

}

?>