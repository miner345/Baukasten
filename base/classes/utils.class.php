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

	public function cleanInput($values, $type)
	{
		if (get_magic_quotes_gpc())
		{
            switch($type) {
                case "mysql" :
                    $inputs = mysql_real_escape_string($values);
                ;
                default:
                    $inputs = mysql_real_escape_string($values);
                ;
            }
		}
	}	
	
	
	/**
	 * getMenu() - Returns an Array
	 */
	
	public function getMenu(){
		$array = explode(',',$this->config->menu_order);
		foreach($array as $menu){
			$check = $this->checkPOE($menu);
			if($check=='extension' || $check=='page'){
				$return[]=$menu;
			}
			else throw new Exception('Fail in Menu Order: '.$menu.' is not an Page or Extension!');
		}
		return $return;
	}
	
}


?>