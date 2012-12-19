<?php

/**
 * Captcha Class
 */

class Captcha{
	
	/**
	 * __construct()
	 */
	
	public function __construct(){
		
	}
	
	/**
	 * printForm() - echos the <input> Tags for a new Security captcha
	 * Must be in a Form
	 */
	
	public function printForm(){
		$a = rand(3,11);
		$b = rand(2,12);
		$sum = $a + $b;
		echo '<label>'.$a.' + '.$b.' = </label>';
		echo '<input type="number" name="captcha_class_input" />';
		echo '<input type="hidden" name="captcha_class_solution" value="'.$sum.'" />';
		return true;
	}
}


?>