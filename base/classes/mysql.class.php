<?php
/**
 * MySQL Class
 */

class MySQL {
	
    public $tables = "";
	/**
	 * __construct - Use the Params to connect
	 */
	
	public function __construct($host, $username, $password, $database){
		try {
			$this->connect($host, $username, $password, $database);
		}
		catch (Exception $e){
			echo 'Exception @ connect(): '.$e;
		}
	}
	
	/**
	 * connect() - Use to connect to database
	 */
	
	public function connect($host, $username, $password, $database){
		if(isset($host) && isset($username) && isset($password), && isset($database)){
			$connection = mysql_connect($host, $username, $password);
			if(!$connection) throw new Exception('Connection to MySQL failed!');
			$db = mysql_select_db($database);
			if(!$database) throw new Exception('Database not found!');
		}
		else throw new Exception('You need to give all parameter!');
	}
	
	/**
	 * query() - Normal MySQL Query
	 */
	
	public function query($query){
		if(isset($query)){
			$result = mysql_query($query);
			if(!$result) throw new Exception('Query Failed!');
			return $result;
		}
		else throw new Exception('You need to give all parameter!');
	}
    
	public function getMultipleQuery($row, $value){
        if(isset($row) && isset($value)) {
            if(count($row) == count($value) && count($row) > 1 && count($value) > 1) {
                /* foreach($row as $rows && $value as $values) {
                
                } */
                $query = "";
                for($i=0; $i = count($row); $i++) {
                    if(gettype($value)=="string") {
                        $query .= "AND `".$row[$i]."` = '".$value[$i]."'";
                        return $query;
                    }
                    elseif(gettype($value)=="integer" || gettype($value)=="double"){
                        $query .= "AND `".$row[$i]."` = ".$value[$i]."";
                        return $query;
                    }
                }
            } else {
                if(gettype($value)=="string") {
                    $query = "`".$row."` = '".$value."'";
                    return $query;
                }
                elseif(gettype($value)=="integer" || gettype($value)=="double"){
                    $query = "`".$row."` = ".$value."";
                    return $query;
                }
            }
        }
		else throw new Exception('You need to give all parameter!');
	}
	
	/**
	 * getArray() - Gets an Array from Table $table and where $row = $value
	 */
	
	public function getArray($table, array(), array()){
		if(isset($table)){
			if(mysql_query('SELECT * FROM `'.$table.'`')){ # Checks if table exists
				if(gettype($value)=="string"){ # Checks the type for different querys
					$result = mysql_query("SELECT * FROM `".$table."` WHERE `".$row."` = '".$value."'");
				}
				elseif(gettype($value)=="integer" || gettype($value)=="double"){
					$result = mysql_query("SELECT * FROM `".$table."` WHERE `".$row."` = ".$value."");
				}
				if(!$result) throw new Exception('Query Failed!');
				else return mysql_fetch_array($result);
			}
			else throw new Exception('Table not found!');
		}
		else throw new Exception('You need to give all parameter!');
	}
}




?>