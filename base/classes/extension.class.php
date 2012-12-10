<?php

/**
 * Extension Class
 */

class Extension {
	
	/**
	 * __construct() - $name is the name of the folder with the extension
	 */
	
	public function __construct($name){
		$this->folder = $name;
	}
	
	/**
	 * validate() - Checks if the Extension is valid.
	 */
	
	public function validate(){
		$return = true;
		
		if(!file_exists($this->folder.'/extension.php')){
			$return = false;
			throw new Exception('Extension invalid: "extension.php" is missing');
		}
		
		return $return;
	}
	
	/**
	 * load() - Loads the Extension
	 */
	
	public function load(){
		if(!require_once($this->folder.'/extension.php')){
			throw new Exception('Loading of Extension failed');
		}
		else {
			$this->config = new ExtensionConfig();
		}
	}
	

}





?>