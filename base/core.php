<?php

/**
 * Core - Loader of the Main parts
 * Database Connection
 * And some other stuff
 */

 /**
  * Start Session
  */
	session_start();
	session_regenerate_id();

/**
 * Loading Config
 */
	include('config.php');
	$config = new Config();
	
/**
 * Autoloader for Classes
 */	
	$include = '.class.php';
	$path = 'base/classes';
	
	$dir = scandir($path);
	$length = strlen($include);
	
	foreach($dir as $data){
		$sub = substr($data, -$length, $length);
		if($sub == $include){
			include($path.'/'.$data);
		}
	}

/**
 * MySQL Connection
 */
	$db = new MySQL();
	
	
/**
 * Load Utils Class
 */
	$utils = new Utils();
	
/**
 * Load CSS Class
 */
	$css = new CSS();
	
 
?>