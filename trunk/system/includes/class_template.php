<?php
	/*
		dG52 PHP and AJAX Poll software

		Author: Douglas Stridsberg
			Email: doggie52@gmail.com
			URL: www.douglasstridsberg.com
	*/
	
global $config;

class template
{

	function __construct()
	{
		// Checks for the 'templates'-folder's existence, as well as template_dictionary's existence
		if(!file_exists(POLL_THEME_DIR."templates"))
		{
			echo "Fatal error!
			<code>templates</code> directory does not exist!";
			exit;
		}
		if(!file_exists(POLL_SYS_DIR."includes/template_dictionary.php"))
		{
			echo "Fatal error!
			<code>template_dictionary.php</code> file does not exist in location <br />";
			echo $config['sysDir']."includes/template_dictionary.php";
			exit;
		}
	}

	private function checkExist($templateName)
	{
		// Checks a $templateName's existence - exit if non-existant
			if(!file_exists(POLL_THEME_DIR."templates/".$templateName.".tpl"))
			{
				echo "Fatal error!
				<code>$templateName.tpl</code> does not exist!";
				exit;
			}
	}

	private function loadTemplate($templateName)
	{
		// Loads $templateName
			if($loadedTemplate = file_get_contents(POLL_THEME_DIR."templates/".$templateName.".tpl", FILE_USE_INCLUDE_PATH))
			{
				return $loadedTemplate;
			}
			else
			{
				echo "Fatal error!
				<code>$templateName.tmpl</code> can not be loaded for reading!";
				exit;
			}
	}

	private function replaceTemplateVars($templateName, $additionalArray = null)
	{
		// Replaces variables in $templateName with those found in $dictionary
		// If available, include an additional array
		// Tutorial used: http://www.php.net/manual/en/function.str-replace.php#95198
	
			// Declare arrays
			$varArray			= array();
			$translatedArray	= array();
			
			// Include dictionary
			require(POLL_SYS_DIR."includes/template_dictionary.php");
	
			// For each dictionary entry, split the variable and the translation into two arrays, before and after
			foreach($dictionary as $before => $after)
			{
				$varArray[] = "%".$before."%";
				$translatedArray[] = $after;
			}
	
			// Replaces the variables with their translated values
			$translatedTemplate = str_replace($varArray, $translatedArray, $templateName);
			return $translatedTemplate;
	}
	
	public function printTemplate($templateName, $additionalArray = null)
	{
		// Combines the previous functions into one, public function that renders the template
			$this->checkExist($templateName);
			$output = $this->replaceTemplateVars($this->loadTemplate($templateName), $additionalArray);
			echo $output;
	}

}

?>