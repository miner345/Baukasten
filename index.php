<?php 
#=============================================#
#              Index of Baukasten             #
#   written by miner345 an dragongun100       #
#=============================================#

/**
 * Checking if Installation is done
 */
	#if(file_exists('./install.php')){
	#	header("Location: install.php");   <---- Temporary Disabled
	#}

/**
 * Including Core
 */
	require_once('./base/core.php');
	

	/*************************** Testing ***********************/
	/***********************************************************/
?>
<!---------------------------- Start of HTML Part ------------------->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title><?php echo $config->name; ?></title>
		
		<!--      Meta       -->
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<meta name="description" content="<?php echo $config->description; ?>">
		<meta name="author" content="<?php echo $config->author; ?>">
		<meta name="keywords" content="<?php echo $config->keywords; ?>">
		
		<!--     Style     -->
		<?php echo $css->load(); ?>
		
	</head>
	<body>
		<div id="wrapper">
			<div id="head">
				<div id="banner"><img src="css/banner.png" alt="Banner of <?php echo $config->name; ?>" /></div>
			</div>
			<div id="main">
				<div id="navigation">
					<ul>
						<a href=""><li><div class="nav_1"></div><div class="nav_2">Test</div><div class="nav_3"></div></li></a>
						<a href=""><li><div class="nav_1"></div><div class="nav_2">Test2</div><div class="nav_3"></div></li></a>
						<a href=""><li><div class="nav_1"></div><div class="nav_2">Test3</div><div class="nav_3"></div></li></a>
						<a href=""><li><div class="nav_1"></div><div class="nav_2">Test4</div><div class="nav_3"></div></li></a>
						<a href=""><li><div class="nav_1"></div><div class="nav_2">Test5</div><div class="nav_3"></div></li></a>
					</ul>
				</div>
                
                <pre>
               <?php
               ################
               $user = new User;
               $user->AdvantageUserPermission();
               ################
               ?>               
               </pre>
                
			</div>
			<div id="footer">
			
			</div>
		</div>
	</body>
</html>