<?php

/**
 * User Class
 */
class User {
    
    public function __construct() {
        $this->utils = new Utils();
        $this->config = new Config();
        $this->mysql = new MySQL();
    }

    public function checkData($user, $pass){
        if(isset($user) && isset($pass)) {
            $pass = md5(sha1($pass));
            if($data = $this->mysql->getMA($table, array(0=>'username', 1=>'password'),  array(0 => '".$user."', 1 => '".$pass."'))) {
                print_r($data);
            }
            else throw new Exception('Username or Password is false!');
        }
		else throw new Exception('You need to give all parameter!');
    }

    
	private function encryptpassworddefault($password) {
		$secret_salt = "26578";
		$salted_Password = $secret_salt.$password;
		$password_hash = hash('sha256', $salted_Password);
		return $password_hash;
	
    }
}


?>