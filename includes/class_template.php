<?php

class template {

	function __construct(){
		// Checks for the 'templates'-folder's existence
		if(!file_exists("templates")){
			echo "Fatal error!
			<code>templates</code> directory does not exist!";
			exit;
		}
		require "includes/template_dictionary.php";
	}

	private function checkExist($templateName){
	// Checks a $templateName's existence - exit if non-existant
		if(!file_exists("templates/".$templateName.".tpl")){
			echo "Fatal error!
			<code>$templateName.tpl</code> does not exist!";
			exit;
		}
	}

	private function loadTemplate($templateName){
	// Loads $templateName
		if($loadedTemplate = file_get_contents("templates/".$templateName.".tpl", FILE_USE_INCLUDE_PATH)){
			return $loadedTemplate;
		}else{
			echo "Fatal error!
			<code>$templateName.tmpl</code> can not be loaded for reading!";
			exit;
		}
	}

	private function replaceTemplateVars($templateName, $dictionary){
	// Replaces variables in $templateName with those found in $dictionary
	// Tutorial used: http://www.php.net/manual/en/function.str-replace.php#95198

		// Declare arrays
		$varArray			= array();
		$translatedArray	= array();

		// For each dictionary entry, split the variable and the translation into two arrays
		foreach($dictionary as $b => $a){
			$varArray[] = "%".$b."%";
			$translatedArray[] = $a;
		}

		// Replaces the variables with their translated values
		$translatedTemplate = str_replace($varArray, $translatedArray, $templateName);
		return $translatedTemplate;
	}
	
	public function printTemplate($templateName){
	// Combines the previous functions into one, public function that renders the template
		$this->checkExist($templateName);
		$output = $this->replaceTemplateVars($this->loadTemplate($templateName));
		echo $output;
	}

}

?>