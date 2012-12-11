<?php

/**
 * User Class
 */
class User {

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
            if($data = $this->mysql->query($this->mysql->getMA("user", "username,password", "".$user.", ".$pass.""))) {
            
            }
            else throw new Exception('Username or Password is false!');
        }
		else throw new Exception('You need to give all parameter!');
    }

    
	/**
	 * changePassword: Change the password from the User
	 */
 
    public function changePassword($user, $oldpw, $npw, $npwrep) {
        if(isset($oldpw) && isset($npw) && isset($npwrep)) {
            $oldpw = md5(sha1($oldpw));
            if($checkoldpw = $this->mysql->query($this->mysql->getMA("user", "username,password", "".$user.", ".$oldpw.""))) {
                if($npw == $npwrep) {
                    $npwrep = md5(sha1($npwrep));
                    if($this->mysql->query("UPDATE `".$this->config->table_prefix."user` SET `".mysql_real_escape_string($npwrep)."`='' WHERE (`username`='".mysql_real_escape_string($user)."') AND (`password`='".mysql_real_escape_string($oldpw)."')")) {
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
		
	public function checkUsernameExist($username) {
		$sqlres = mysql_query("SELECT username FROM user WHERE username = '".mysql_real_escape_string($username)."'");
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
                                            if($doregist = mysql_query("INSERT INTO user (username,password,register_ip,email) VALUES ('".$user."','".$pass."',NOW(),'".trim(mysql_real_escape_string($email))."')")) {
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
                                    if($doregist = mysql_query("INSERT INTO user (username,password,register_ip) VALUES ('".$user."','".$pass."',NOW())")) {
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
}
?>