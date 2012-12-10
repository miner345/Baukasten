<?php

/**
 * CSS class
 */

class CSS {
	
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
	
	
}

?>