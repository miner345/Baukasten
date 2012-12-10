<?php

/**
 * Installation File
 * Setting up MySQL Database
 */

/**
 * Include Core
 */ 
	require_once('./base/core.php');

/**
 * Create Tables
 */



/**
 * Destroy itself an header to index.php
 */
	if($success){
		unlink('./install.php');
		header('Location: index.php');
	}
	else echo '<br /><br /> == The Installation failed == ';
	
?>