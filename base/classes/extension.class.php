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
	
	/**
	 * getCSS() - Returns the given Stylesheet from extension.php in a meta tag.
	 */
	
	public function getCSS() {
		if($this->config->add_css!=""){
			if(file_exists($this->folder.'/'.$this->config->add_css)){
				return '<link rel="stylesheet" type="text/css" href="'.$this->folder.'/'.$this->config->add_css.'">';
			}
			else return '<!-- Error! The given Stylesheet of Extension '.$this->folder.' isn\'t there! -->';
		}
	}
	
	/**
	 * getJS() - Returns the meta tag for the javascript given in extension.php
	 */
	
	public function getJS() {
		if($this->config->add_js!=""){
			if(file_exists($this->folder.'/'.$this->config->add_js)){
				return '<script language="javascript" type="text/javascript" src="'.$this->folder.'/'.$this->config->add_js.'">';
			}
			else return '<!-- Error! The given Javascript of Extension '.$this->folder.' isn\'t there! -->';
		}
	}
	
	/**
	 * loadPHP() - Use to load the Content of the Extension.
	 */
	
	public function loadPHP() {
		if($this->config->main_php != "" && file_exists($this->folder.'/'.$this->main_php)){
			include($this->folder.'/'.$this->main_php);
		}
		else echo 'FATAL Error in Extension: Main php file not found!';
	}

}





?>