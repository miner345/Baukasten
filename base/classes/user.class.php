<?php

/**
 * User Class
 */
 
class User {
    
    __construct() {
        $this->utils = new Utils();
        $this->mysql = new MySQL();
        $this->config = new Config();
    }

    public function checkData($user, $pass){
        if(isset($user) && isset($pass)) {
            $user = $this->utils->cleanup($user);
            $pass = $this->utils->cleanup($pass);
            $pass = md5(sha1($pass));
            if($data = $this->mysql->getMA($table, "username,password", "".$user.",".$pass."")) {
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


?>