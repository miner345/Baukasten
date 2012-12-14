<?php

/**
 * User Class
 */
class User {

	public $name; #safe later the username
	public $id; #safe later the id
	public $isAdmin = false; #safe later the Admin
		
	/**
	 * This load the object from the classes
	 */
	
    public function __construct() {
        $this->utils = new Utils();
        $this->config = new Config();
        $this->mysql = new MySQL();
    }
	
	/**
	 * Login:Login the User in a secrue page :D
	 */

    public function login($user, $pass, $pogress = "") {
    	if(!empty($user) || !empty($pass) && isset($pogress) && empty($pogress)) {
    		$pass = $this->encrypt_password($pass);
    		$result = $this->mysql->getArray("user", "name", $user, "password", $pass);
    		if($result) {
    			if($this->encrypt_password($result['password']) == $pass) {
    				$this->name = $result['name'];
    				$this->id = $result['id'];
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
     * updateUser: User get every login a new ip in mysql thats is "last_ip"
     */
    
    
    public function updateUser() {
    	if(!empty($this->name)) {
    		$user = $this->name;
    		$this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `last_ip`= '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' `last_timestamp` = NOW() WHERE (`name`='".mysql_real_escape_string($user)."'");
    	}
    }    
 
    /**
     * changePassword: Change the password from the User
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
	 * forgotPassword: chnage the passwort autimaticly with email support
	 */
    
    public function forgotPassword($username = "", $email = "") {

    }
    
	/**
	 * checkValidUsername: check if username is valid
	 */

    
	public function checkValidUsername($username) {
		if(preg_match('/^[a-zA-Z0-9][\w]+[a-zA-Z0-9]$/', $username)) {
			return true;	
		} else {
			return false;
		}
	}
	
	
	/**
	 * checkValidEmail: check if Email is valid
	 */
	
	public function checkValidEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * checkUsernameExist: check if Username is exist
	 */
		
	public function checkUsernameExist($username = "", $id = "") {
		$sqlres = mysql_query("SELECT username FROM user WHERE username = '".mysql_real_escape_string($username)."' OR id = $id");
		if(mysql_num_rows($sqlres)) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * checkEmailExist: check if E-Mail is exist
	 */
	
	public function checkEmailExist($email) {
		$sqlres = mysql_query("SELECT email FROM user WHERE email = '".mysql_real_escape_string($email)."'");
		if(mysql_num_rows($sqlres)) {
			return false;
		} else {
			return true;
		}
	}
    
	/**
	 * encrypt_password: crypt the Passwort ;D
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
     * register: Do regist a User 
     */
    
    
    public function register($user, $pass, $passrep, $email = "") {
	   	if($user == null || $pass == null || $passrep == null) {
	   		throw new Exception('Please fill all the fields!');
	   	} else {
	   		if($checkExistUsername = $this->checkUsernameExist($user)) {   # Check is username aviable
	   			if($checkValidUsername = $this->checkValidUsername($user)) { # Check is username valid
			   		if(strlen($user) >= $this->config->minUsernameLen) {	# Check weather in config, if the username have a minimum of leng
			   			if(strlen($pass) >= $this->config->minPasswordLen) { # Check weather in config, if the password have a minimum of leng
			   				if($pass == $passrep) {								# Check if password and password2 match
			   					$user = trim(mysql_real_escape_string($user));	 
			   					$pass = trim(mysql_real_escape_string($pass));
                                if(!empty($email)) {							# Check if filled email
                                    if($checkValidEmail = $this->checkValidEmail($email)) { # Check if email is valid
                                        if($checkEmailExist = $this->checkEmailExist($email)) { # Check is email aviable 
                                            $pass = $this->encrypt_password($pass);				# crypt the password
                                            if($doregist  = $this->mysql->query("INSERT INTO user (name,password,register_ip,register_timestamp, email) VALUES ('".$user."','".$pass."','".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',NOW(), '".trim(mysql_real_escape_string($email))."')")) {  # do write the world in database
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
     * onPage: write in the databse the actually pagename and update the last_ip, last_timestamp
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
     * getUser: Regenerate new username and id, how you can pickup it with $user = new User;m $user->name or $user->id
     */
    
    public function getUser() {
    	if(empty($this->name) && empty($this->id)) {
    		if(empty($_SESSION)) {
    			return false;
    		} else {
    			if ($this->checkUsernameExist("", $_SESSION['USERID'])) {
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
    			echo "Error in isAdmin";
    			return false;
    		}
    	}
    }
    
    
    public function AdvantageUserPermission() {
    	if($this->config->useAPS == true) {
	    	
    		$search = '.page.php';
	    	$path = 'pages';

	    	print_r($dir = scandir($path));
	    	foreach($dir as $string) {
	    		$pos = strpos($string, $search);
				$return = substr($string, 0, $pos);
	    	}
    	}
    }
}
?>