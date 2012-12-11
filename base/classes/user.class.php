<?php

/**
 * User Class
 */
class User {

	
	var $name ;
	var $id;
		
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

    public function login($user, $pass){
        if(isset($user) && isset($pass)) {
            $pass = md5(sha1($pass));
            if($data = $this->mysql->query($this->mysql->getArray("user", "name", $user, "password", $pass))) {
            	$this->name = $user;
            }
            else throw new Exception('Username or Password is false!');
        }
		else throw new Exception('You need to give all parameter!');
    }

    
    /**
     * updateUser: User get every login a new ip in mysql thats is "last_ip"
     */
    
    
    public function updateUser() {
    	if(!empty($this->name)) {
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
        $password = md5(sha1($password));
        return $password;
    }
    
    public function register($user, $pass, $passrep, $email = "") {
	   	if($user == null || $pass == null || $passrep == null) {
	   		throw new Exception('Please fill all the fields!');
	   	} else {
	   		if($checkExistUsername = $this->checkUsernameExist($user)) {
	   			if($checkValidUsername = $this->checkValidUsername($user)) {
			   		if(strlen($user) >= $this->config->minUsernameLen) {
			   			if(strlen($pass) >= $this->config->minPasswordLen) {
			   				if($pass == $passrep) {
			   					$user = trim(mysql_real_escape_string($user));
			   					$pass = trim(mysql_real_escape_string($pass));
                                if(!empty($email)) {
                                    if($checkValidEmail = $this->checkValidEmail($email)) {
                                        if($checkValidEmail = $this->checkEmailExist($email)) {
                                            $pass = $this->encrypt_password($pass);
                                            if($doregist = mysql_query("INSERT INTO user (name,password,register_ip,register_timestamp, email) VALUES ('".$user."','".$pass."','".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',NOW(), '".trim(mysql_real_escape_string($email))."')")) {
                                                echo "<span style='color:green'>Registrierung ist erfolgreich.</span>";
                                            }
                                            else { echo("An Error code on Regi code: 2");}        
                                        }
                                        else { echo("The E-Mail is already exist!");}                                       
                                    }
                                    else { echo("Please enter a valid E-Mail!");}  
                                }
                                else {
                                    $pass = $this->encrypt_password($pass);
                                    if($doregist = mysql_query("INSERT INTO user (name,password,register_ip) VALUES ('".$user."','".$pass."',NOW())")) {
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
    
    
    public function onPage($pagename) {
    	if(!empty($pagename)) {
    		$this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `last_ip`= '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."', `last_timestamp` = NOW(), `last_page` = '".mysql_real_escape_string($pagename)."' WHERE (`name`='".mysql_real_escape_string($user)."'");
    	} 
    	else {
    		echo "Pagename is empty!";
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
}
?>