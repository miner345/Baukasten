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
 * Loogin: the Login do check the user data and if match..
 */
 
    public function login($user, $pass){
        if(isset($user) && isset($pass)) {
            $pass = md5(sha1($pass));
            if($data = $this->mysql->getMA($this->config->table_prefix."user", array(0=>'username', 1=>'password'),  array(0 => "$user", 1 => "$pass"))) {
                print_r($data);
            }
            else throw new Exception('Username or Password is false!');
        }
		else throw new Exception('You need to give all parameter!');
    }

    
/**
 * changePassword: Change the password
 */
 
    public function changePassword($user, $oldpw, $npw, $npwrep) {
        if(isset($oldpw) && isset($npw) && isset($npwrep)) {
            $oldpw = md5(sha1($oldpw));
            if($checkoldpw = $this->mysql->getMA($this->config->table_prefix."user", array(0 => 'username', 1 => 'password'), array(0 => "$user", 1 => "$oldpw"))) {
                if($npw == $npwrep) {
                    $npwrep = md5(sha1($npwrep));
                    if($this->mysql->query("UPDATE `user` SET `".$npwrep."`='' WHERE (`username`='".$user."') AND (`password`='".$oldpw."')")) {
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
    
    public function forgotPassword($user, $email = "") {
        if(isset($user) || isset($email)) {
        /*
            Later
        */
        }
    }
}


?>