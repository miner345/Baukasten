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
		public $add_css = "css/style.css";
		
		# Location of additional Javascript which needs to be included in <head>
		public $add_js = "js/js.js";
		
		# Your Main PHP file:
		public $main_php = "main.php";
		# You need to load your additional PHP files like
		# classes on your own.
		
		# Sidebar File
		# Only useful, if you set $sidebar to true in the Options below
		public $sidebar_file = "";
	
	# Extension options 

		# Name in Navigation
		public $name_in_navigation = "Example";
		
		# Author
		public $author = "miner345";
		
		# Sidebar - Set to true to get an Sidebar
		# Define the Sidebar file in the Additional Files parts above.
		public $sidebar = false;
}














?>