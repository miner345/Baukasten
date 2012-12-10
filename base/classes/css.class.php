<?php

/**
 * CSS class
 */

class CSS {
	
	$this->style = 'default.css';
	
	/**
	 * getStyles() - Returns an array with [file] as the filename and [name] as the given name in first line
	 */
	
	public function getStyles(){
		$include = '.css';
		$path = 'css';
		
		$dir = scandir($path);
		$length = strlen($include);
		
		foreach($dir as $data){
			$sub = substr($data, -$length, $length);
			if($sub == $include){
				$files[] = $data;
			}
		}
		
		
		foreach($files as $file){
			$fp = @fopen($path.'/'.$file, "r");
			$line = fgets($fp);
			$name = substr($line, 2, -3);
			$return[] = array('file' => $file, 'name' => $name);
		}
		
		return $return;
	}
	
	/**
	 * validate() - Validates the $this->style
	 */
	
	public function validate() {
		if(file_exists('css/'.$this->style)){
			return true;
		}
		else return false;
	}
	
	/**
	 * load() - Loads the chosen Style - Returns the meta line - Use only in <head></head>
	 */
	
	public function load(){
		if($this->validate()){
			return '<link rel="stylesheet" type="text/css" href="css/'.$this->style.'">';
		}
	}
	
	
}

?>