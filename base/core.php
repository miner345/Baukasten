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
	$db = new MySQL($config->mysql_host, $config->mysql_user, $config->mysql_password, $config->mysql_database);
	
	
/**
 * Load Utils
 */
	$utils = new Utils($config);
 
?>