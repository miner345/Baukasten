<?php

/**
 * User Class
 */
 
class User {
		
    var $_SESSION['loggedIn'] = false
    
    public __construct($user, $pass) {
        $this->utils = new Utils();
        $this->mysql = new MySQL();
        $this->config = new Config();
    }

    public function doLogin($user, $pass) {
    
    }

    public function checkData($user, $pass){
        if(isset($user) && isset($pass)) {
            $user = $this->utils->cleanup($user);
            $pass = $this->utils->cleanup($pass);
            if($data = $this->mysql->getMA($table, "username,password", "".$user.",".$pass."")) {
                self::doLogin($userm $pass);
            }
            else throw new Exception('Username or Password is false!');
        }
		else throw new Exception('You need to give all parameter!');
    }

}


?>