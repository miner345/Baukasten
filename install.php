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

 $success = true;

$res1 = mysql_query("
CREATE TABLE `".$config->table_prefix."user` (
`id` INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR(100) NOT NULL ,
`email` VARCHAR(100) NOT NULL ,
`password` VARCHAR(255) NOT NULL ,
`register_ip` VARCHAR(50) NOT NULL ,
`last_ip` VARCHAR(50) NOT NULL ,
`register_timestamp` INT(100) NOT NULL ,
`sess_timeout` INT(255) NOT NULL ,
`last_timestamp` INT(100) NOT NULL )");


$res1 = mysql_query("
CREATE TABLE `".$config->table_prefix."user_aps` (
`id` int(255) NOT NULL,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

if(!$res1) $success = false;


/**
 * Destroy itself an header to index.php
 */
	if($success){
		unlink('./install.php');
		header('Location: index.php');
	}
	else echo '<br /><br /> == The Installation failed == ';
	
?>