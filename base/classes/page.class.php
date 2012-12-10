<?php

/**
 * Page Class
 */

class Page {
	
	
	/**
	 * __construct() - $name is name of page
	 */
	
	public function __construct($name){
		$this->name = $name;
	}
	
	/**
	 * load() - Loads the Page
	 */
	
	public function load(){
		try {
			$res = include('pages/'.$this->name.'.page.php');
		}
		catch(Exception $e){
			throw new Exception($e);
		}
		
	}
}


?>