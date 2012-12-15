<?php

/**
 * User Class
 */
class User {

	public $name; #safe later the username
	public $id; #safe later the id
	public $isAdmin = false; #safe later the Admin
	public $session = false;
	public $sessionid;
	public $timeout;
		
	/**
	 * __construct() - This loads some other classes for later use
	 */
	
    public function __construct() {
        $this->utils = new Utils();
        $this->config = new Config();
        $this->mysql = new MySQL();
    }
	
	/**
	 * login() - Logs in
	 */

    public function login($user, $pass, $pogress = "") {
    	if(!empty($user) || !empty($pass) && isset($pogress) && empty($pogress)) {
    		$pass = $this->encrypt_password($pass);
    		$result = $this->mysql->getArray("user", "name", $user, "password", $pass);
    		if($result) {
    			if($this->encrypt_password($result['password']) == $pass) {
    				$this->name = $result['name'];
    				$this->id = $result['id'];
    				$this->setPermissions($result['id'], $result['name'], $this->config->login_timeout, $this->config->login_time);
    				$this->setSession();
    				return true;    				
    			} else {
    				echo "Wrong Password!";
    			}	
    		} else {
    			return false;
    		}		    		
    	} else {
    		echo ("Fill all the fields!");
    	}
    }

    
    /**
     * updateUser() - Sets the last_ip column in user database
     */
    
    
    public function updateUser() {
    	if(!empty($this->name)) {
    		$user = $this->name;
    		$this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `last_ip`= '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' `last_timestamp` = NOW() WHERE (`name`='".mysql_real_escape_string($user)."'");
    	}
    }    
 
    /**
     * changePassword() - Changes the password from the user
     */
    
    public function changePassword($oldpw, $npw, $npwrep) {
        if(isset($oldpw) && isset($npw) && isset($npwrep)) {
            $oldpw = $this->encrypt_password($oldpw);
            $user = mysql_real_escape_string($this->name);
            $oldpw = mysql_real_escape_string($oldpw);
            if($checkoldpw = $this->mysql->query("SELECT * FROM `user` WHERE `name` = '".$user."' AND `password` = '.$oldpw.'")) {
                if($npw == $npwrep) {
                    $npwrep = $this->encrypt_password($npwrep);
                    if($this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `password` = '".mysql_real_escape_string($npwrep)."' WHERE (`name`='".mysql_real_escape_string($user)."') AND (`password`='".mysql_real_escape_string($oldpw)."')")) {
                        return true;
                    }
                    else throw new Exception('ERROR in changePassword!');
                }
                else throw new Exception('The new Passwords don´t match!');
            }
            else throw new Exception('The Old password is false!');
        }
        else throw new Exception('You need to give all parameter!');
    }
    
	/**
	 * forgotPassword() - change the password automatically with email support
	 */
    
    public function forgotPassword($username = "", $email = "") {

    }
    
	/**
	 * validateUsername() - checks if the username is valid
	 */

    
	public function validateUsername($username) {
		if(preg_match('/^[a-zA-Z0-9][\w]+[a-zA-Z0-9]$/', $username)) {
			return true;	
		} else {
			return false;
		}
	}
	
	
	/**
	 * validateEmail() - checks if Email is valid
	 */
	
	public function validateEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * checkUsername() - checks if Username exists
	 */
		
	public function checkUsername($username = "", $id = "") {
		$sqlres = mysql_query("SELECT username FROM user WHERE username = '".mysql_real_escape_string($username)."' OR id = $id");
		if(mysql_num_rows($sqlres)) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * checkEmail: check if E-Mail exists
	 */
	
	public function checkEmail($email) {
		$sqlres = mysql_query("SELECT email FROM user WHERE email = '".mysql_real_escape_string($email)."'");
		if(mysql_num_rows($sqlres)) {
			return false;
		} else {
			return true;
		}
	}
    
	/**
	 * encrypt_password() - encrypts the password
	 */
	
	public function encrypt_password($password) {
        if(!empty($password)) {
        	$password = md5(sha1($password));
        	return $password;
        }
        else {
        	return false;
        }
    }
    

    /**
     * register() - Adding an user to database
     */
    
    
    public function register($user, $pass, $passrep, $email = "") {
	   	if($user == null || $pass == null || $passrep == null) {
	   		throw new Exception('Please fill all the fields!');
	   	} else {
	   		if($checkExist = $this->checkUsername($user)) {   # Check if username is available
	   			if($validateUsername = $this->validateUsername($user)) { # Check if username is valid
			   		if(strlen($user) >= $this->config->minUsernameLen) {	# Checks in config, if the username have a minimum of length
			   			if(strlen($pass) >= $this->config->minPasswordLen) { # Checks in config, if the password have a minimum of length
			   				if($pass == $passrep) {								# Check if password and password2 match
			   					$user = trim(mysql_real_escape_string($user));	 
			   					$pass = trim(mysql_real_escape_string($pass));
                                if(!empty($email)) {							# Check if filled email
                                    if($validateEmail = $this->validateEmail($email)) { # Check if email is valid
                                        if($checkEmail = $this->checkEmail($email)) { # Check if email is available 
                                            $pass = $this->encrypt_password($pass);				# encrypts the password
                                            if($doregist = $this->mysql->query("INSERT INTO `user` (name,password,register_ip,register_timestamp,email) VALUES ('".$user."','".$pass."','".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',NOW(), '".trim(mysql_real_escape_string($email))."')")) {  # writes the datas in database
                                                return true;
                                            }
                                            else { echo("An Error code on Regi code: 2");}        
                                        }
                                        else { echo("The E-Mail is already exist!");}                                       
                                    }
                                    else { echo("Please enter a valid E-Mail!");}  
                                }
                                else {
                                    $pass = $this->encrypt_password($pass);
                                    if($doregist = $this->mysql->query("INSERT INTO user (name,password,register_ip,last_timestamp) VALUES ('".$user."','".$pass."','".$_SERVER['REMOTE_ADDR']."',NOW())")) {
                                        echo "<span style='color:green'>Registrierung ist erfolgreich.</span>";
                                    }
                                    else { echo("An Error code on Regi code: 1");}       
                                }	                                
			   				}
                            else { echo("The password dont match!");}    
			   			}
                        else { echo("The minimum number to register for password is ".$this->config->minPasswordLen."");}
			   		}
                    else { echo("The minimum number to register for username is ".$this->config->minPasswordLen."");}
			   	} 
                else { echo("Please enter a valid username!");}
	   		} 
            else { echo("The username is already exist!");}
	   	}    
    }
    

    /**
     * onPage() - writes in the database the pagename and update the last_ip, last_timestamp
     */    
    
    public function onPage($pagename) {
    	if(!empty($pagename)) {
    		$this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `last_ip`= '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."', `last_timestamp` = NOW(), `last_page` = '".mysql_real_escape_string($pagename)."' WHERE (`name`='".mysql_real_escape_string($user)."'");
    	} 
    	else {
    		echo "Pagename is empty!";
    		return false;
    	}    	
    }
    
    /**
     * getUser() - Regenerate new username and id, how you can pickup it with $user = new User;m $user->name or $user->id
     */
    
    public function getUser() {
    	if(empty($this->name) && empty($this->id)) {
    		if(empty($_SESSION)) {
    			return false;
    		} else {
    			if ($this->checkUsername("", $_SESSION['USERID'])) {
    				$rows = $this->mysql->getArray("user", "id", $_SESSION['USERID']);
    				$this->name = $rows['name'];
    				$this->id = $rows['id'];
    				return true;
    			}
    		}	
    	} else {
    		return true;
    	}		
    }
    
    
    /**
     * isAdmin() - Check  a user if he is Admin 
     */
        
    public function isAdmin() {
    	if(empty($this->name) && empty($this->id)) {
    		$this->getUser();
    		return false;
    	} else {
    		$check = $this->mysql->getArray("user", "name", $this->name, "id", $this->id);
    		if($check) {
    			$this->isAdmin = $check['isAdmin'];
    			if($this->isAdmin) {
    				$this->isAdmin = true;	
    				return true;
    			} else {
    				$this->isAdmin = false;
    				return false;	
    			}
    		} else {
    			echo "Error in isAdmin()";
    			return false;
    		}
    	}
    }
    
    /**
     * AdvantageUserPermission: This is an advantage user Permission System,
     * if in the root directory have for example : home.page.php and news.page.php
     * then the mysql table : user_aps get the home and the news column to controle this
     */
        
    public function AdvantageUserPermission() {
    	if($this->config->useAPS == true) {	    	
    		$search = '.page.php';
	    	$path = 'pages/';
            $string = scandir($path);
            unset($string[0]);
            unset($string[1]);
            sort($string);
            $cstring = count($string);

	    	for($i = 0; $i <= $cstring-1; $i++) {
                $pos[$i] = strpos($string[$i], $search);
				$return[$i] = substr($string[$i], 0, $pos[$i]);
				
				if(file_exists($path.$return[$i].$search)) {
					if(mysql_query("SELECT ".$return[$i]." FROM ".$this->config->table_prefix."user_aps") == true) {
						echo "<br />Exestiet: ". $return[$i];
					} 
					else {
						$this->mysql->query("ALTER TABLE `".$this->config->table_prefix."user_aps` ADD COLUMN `".$return[$i]."`  int(2) NOT NULL AFTER `name`;");
						echo "<br />Wurde Erstellt: ". $return[$i];
					}
				}					
	    	}
	    	$list = mysql_query("SELECT * FROM ".$this->config->table_prefix."user_aps");
	    	if ($list) {
	    		$chlist = mysql_num_fields($list);
	    		for($x = 0; $x < $chlist; $x++) {
	    			$newList[$x] = mysql_field_name($list, $x);
	    			if ($x == $chlist-1) {
	    				unset($newList[0]);
	    				unset($newList[1]);
	    				sort($newList);
	    			}
	    		}
	    		$x = 0;
	    		$zz = 0;	
	    		$y = 0;
	    		$yy = 0;
				$cnewList = count($newList);	    		    			    		
	    		for($y = 0; $y <= $cnewList-1; $y++) {    
	    			$skey1 = array_search($return[$y], $newList);
	    			$skey = array_search($return[$y], $newList);
	    			if($skey) {
	    				if($yy == 0) {
	    					$skey1 = array_search($return[0], $newList);
	    					unset($newList[$skey1]);
	    					$yy++;
	    				}
	    				unset($newList[$skey]);
	    			}
	    		}
	    		sort($newList);
	    		for($zz = 0; $zz < count($newList); $zz++) {
	    			echo "<br>wurden nicht gefunden: ".$newList[$zz];
	    			$getdlist[$zz] = $newList[$zz];
	    			mysql_query("ALTER TABLE `".$this->config->table_prefix."user_aps` DROP COLUMN `".$newList[$zz]."`;");
	    			echo "<br>wurden gelöscht: ".$newList[$zz];
	    		}
	    		$zz = 0;
	    	}
    	} 
    }
    
    /**
     * setPermissions: Set the Permisson table in user_aps 
     */
    
    public function setPermissions() {
    	if (empty($this->name) || $this->id) {
    		$this->getUser();
    	} else {
    		$checkperm = $this->mysql->query("SELECT * FROM ".$this->config->table_prefix."user_aps WHERE name = '".$this->name."' AND id = ".$this->id."");
    		if($checkperm) {
    			return true;
    		} else {
    			$insert = $this->mysql->query("INSERT INTO user_aps (id,name) VALUES (".$this->id.", '".$this->name."')");
    			if ($insert) {
    				return true;
    			} else {
    				echo "Error in setPermission!";
    			}
    		}
    	}
    }
    
    /**
     * setSession: Set the Session by Login 
     */
        
    public function setSession($id, $user = "", $usetime, $time) {
    	if (empty($this->name) || $this->id) {
    		$this->getUser();
    	} else {
    		if($usetime) {
    			$time = time() + 60 * $time;
    			$_SESSION['USERTIME'] = $time;
    		}
    		$_SESSION['USERID'] = $id;
    		$_SESSION['LOGGEDIN'] = true;
    		$this->session = true;
    		$this->sessionid = $id;
    		$this->timeout = $time;
    	} 	
    }
    
    /**
     * checkSession: Checks the Session, when Session broken, session will destroyed
     * OR if the time out session get destroy
     */
    
    public function checkSession($usetime, $time) {
    	if(empty($_SESSION['USERID']) || $_SESSION['LOGGEDIN'] == false || empty($_SESSION)) {
    		$this->session = false;
    		$this->sessionid = null;
    		session_destroy();
    		return false;
    	} else {
    		if ($usetime) {
    			if ($_SESSION['USERTIME'] < time() || $this->timeout < time()) {
    				$this->session = false;
    				$this->sessionid = null;
    				$this->timeout = null;
    				session_destroy();
    				return false;
    			} else {
    				return true;	
    			}
    		}	
    	}
    }
}
?>