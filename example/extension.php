<?php
/**
 * extension.php
 * Example 
 */

class ExtensionConfig {
	
	# Path to additional Files. Start your Path in the Extension folder
	# Example:
	# 	http://yourdomain.com/extension/css/style.css
	# 	public $add_css = "css/style.css";
	
		# Location of additional CSS
		public $add_css = "style.css";
		
		# Location of additional Javascript
		public $add_js = "js.js";
		
		# Your Main PHP file:
		public $main_php = "main.php";
		# You need to load your additional PHP files like
		# classes on your own.
	
	# Extension options 

		# Name in Navigation
		public $name_in_navigation = "Example";
		
		# Author
		public $author = "miner345";
		
}














?>