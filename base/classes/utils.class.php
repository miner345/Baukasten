<?php

/**
 * Utils Class
 */

class Utils {
	
	/**
	 * __construct() - $config gives the Config values to Utils class
	 */
	
	public function __construct($config){
		$this->config = $config;
	}
	
	/**
	 * checkPOE() - checks Page OR Extension of $check
	 */
	
	public function checkPOE($check){
		$ext = $this->getConfigExtensions();
		if(in_array($check, $ext)){
			return "extension";
		}
		elseif(file_exists('pages/'.$check.'.page.php')){
			return "page";
		}
		else throw new Exception('No Page or Extension');
	}
	
	/**
	 * getConfigExtensions() - Returns an Array of the Extensions in the Config
	 */
	
	public function getConfigExtensions(){
		$array = explode(',',$this->config->extensions);
		return $array;
	}
	
	/**
	 * cleanInput() - Clean the form inputs
     * type like: mysql
	 */

	public function cleanInput($values = array(), $type)
	{
		if (get_magic_quotes_gpc())
		{
            switch($type) {
                case "mysql" :
                    $inputs = mysql_real_escape_string($values);
                ;
                default:;
            }
		}
	}	
	
}


?>