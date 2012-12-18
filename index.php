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
	
/**
 * Checking page
 */
	if(empty($_GET['p'])) $page = 'home';
	else $page = $_GET['p'];
	
	if($type = $utils->checkPOE($page)){
		if($type=='extension'){
			$ext = new Extension($page);
			if($ext->validate()){
				$ext->load();
			}
		}
	}
	else header("Location: index.php");
	
	

	/*************************** Testing ***********************/
	/***********************************************************/
?>
<!---------------------------- Start of HTML Part ------------------->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title><?php echo ucfirst($page); ?> - <?php echo $config->name; ?></title>
		
		<!--      Meta       -->
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<meta name="description" content="<?php echo $config->description; ?>">
		<meta name="author" content="<?php echo $config->author; ?>">
		<meta name="keywords" content="<?php echo $config->keywords; ?>">
		
		<!--     Style     -->
		<?php echo $css->load(); ?>
		<?php if($type=='extension') echo $ext->getCSS(); ?>
		
		<!--     Javascript     -->
		<?php if($type=='extension') echo $ext->getJS(); ?>
		
	</head>
	<body>
		<div id="wrapper">
			<div id="head">
				<div id="banner"><img src="css/banner.png" alt="Banner of <?php echo $config->name; ?>" /></div>
			</div>
			<div id="main">
				<div id="navigation">
					<ul>
						<?php
							foreach($utils->getMenu() as $menu){
								echo '<a href="'.$menu['link'].'"><li><div class="nav_1"></div><div class="nav_2">'.$menu['show'].'</div><div class="nav_3"></div></li></a>';					
							}
						?>
					</ul>
				</div>
                
				<div id="content">
					<?php 
						if($type=='extension'){
							$ext->loadPHP();
						}
						elseif($type=='page'){
							include('pages/'.$page.'.page.php');
						}
						elseif($type='system'){
							include('base/system/'.$page.'.sys.php');
						}
						
					?>
				</div>
                
			</div>
			<div id="footer">
			
			</div>
		</div>
	</body>
</html>