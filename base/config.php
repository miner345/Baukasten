<?php
/**
 * Main Config File
 */

class Config {
	
/**
 * Main
 */
	
	# Name of your Page
	public $name = "";
	
	# Menu Order 
	# Write the Pages in the Menu in the Order you want
	# Seperate with , but without spaces.
	# For pages write the part infront of the .page.php and for Extensions write the foldername
	public $menu_order = "example,home";
	
/**
 * Meta
 */

	# Description of Your Page (Appears in Google etc.)
	public $description = "";
	
	# Author | Your Name or Nickname
	public $author = "";
	
	# Keywords | Important words, which help Google Users to find your Page better
	# Multiple keywords are seperated with a ,  (Key, word, bla, bla)
	public $keywords = "";
 
/**
 * MySQL Database Configuration
 */ 
	
	# Host
	public $mysql_host = "vweb05.nitrado.net";
	
	# Username
	public $mysql_user = "ni55453_2sql6";
	
	# Password
	public $mysql_password = "2392e5ae";
	
	# Database
	public $mysql_database = "ni55453_2sql6";
	
/**
 * Extensions
 */
	
	# List all Extension, which should be loaded.
	# The name of the Extension is the name of the folder
	# Seperate multiple Extensions with ' but without spaces
	# Example: public $extensions = "example,extension,blabla";
	public $extensions = "example,extension,blabla";
}

?>