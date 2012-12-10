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
 
    public function changePassword($user, $email = "") {
        
        
    }
}


?>