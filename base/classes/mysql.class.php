<?php
/**
 * MySQL Class
 */

class MySQL {
		
	/**
	 * __construct - Use the Params to connect
	 */
	
	public function __construct(){
		try {
			$this->config = new Config();
			$this->connect($this->config->mysql_host, $this->config->mysql_user, $this->config->mysql_password, $this->config->mysql_database);
		}
		catch (Exception $e){
			echo 'Exception @ connect(): '.$e;
		}
	}
	
	/**
	 * connect() - Use to connect to database
	 */
	
	public function connect($host, $username, $password, $database){
		if(isset($host) && isset($username) && isset($password) && isset($database)){
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
			if(!$result) {
				echo "<br />Query Failed!<br />".mysql_error()."";
			}
			else {
				$result = mysql_free_result($result);
				return $result;
			}
		}
		else throw new Exception('You need to give all parameter!');
	}

	/*
	 * getMA() - Gets an Array from Table $table and where $row = $value AND $row2 = $value2....
	 * 	$table = to select a who table for example: select * FROM ---> $table <---
	 * 	$row = to select a what look for, for example: select * FROM user WHERE ---> username <--- = 'anamefromtable'
	 * 	$value =The value from $row for exmaple: select * FROM user WHERE username = ---> 'dragongun100' <----
	 * 	$usegetMASQL = to use in this function the function query() and mysql_fetch_array()
	 * 	$useQuery = to use only query() 
	 *  
	 *  if $usegetMASQL and $useQuery False then send you the SQL code in a string or integer
	 *  waring if is both by true, this givs an error! 
	 */
	    
	public function getMA($table, $row, $value, $usegetMASQL = false, $useQuery = false){
        if(isset($row) && isset($value)) {
        	$table_prefix = $this->config->table_prefix;
            $query = "SELECT * FROM `".$table_prefix.$table."` WHERE ";
            $row = explode(",", $row);
            $value = explode(",", $value);
            if(count($row) == count($value) && count($row) > 1 && count($value) > 1) {
                for($i=0; $i <= count($row); $i++) {
                    if(gettype($value[$i])=="string") {
                        if($i == 0) {
                        $query .= "`".$row[0]."` = '".$value[0]."'";
                        }
                        else {
                            $query .= " AND `".$row[$i]."` = '".$value[$i]."'";
                        }
                    }
                    elseif(gettype($value[$i])=="integer" || gettype($value[$i])=="double"){
                        if($i == 0) {
                            $query .= "`".$row[0]."` = '".$value[0]."'";
                        }
                        else {
                            $query .= " AND `".$row[$i]."` = ".$value[$i]."";
                        }
                    }
                }
                
                if ($usegetMASQL == true || $usegetMASQL == true && $useQuery == true) {
                	$newRows = mysql_fetch_array(mysql_query($query));
                	return $newRows;
                }
                elseif ($useQuery == true && $usegetMASQL = false) {
                	$query = $this->query($query);
                	return $query;
                }
                else {
                	return $query;
                }
                
            } else {
                if(gettype($value)=="string") {
                    $query = "`".mysql_real_escape_string($row)."` = '".mysql_real_escape_string($value)."'";

                    
                    if ($usegetMASQL == true) {
                    	if($query = $this->query($query)) {
                    		return mysql_fetch_object($query);
                    	} else {
                    		echo "Query Failed! on getMA";
                    	}
                    }
                    elseif ($useQuery == true) {
                    	$query = $this->query($query);
                    	return $query;
                    }
                    else {
                    	return $query;
                    }
                    
                    
                }
                elseif(gettype($value)=="integer" || gettype($value)=="double") {
                    $query = "`".mysql_real_escape_string($row)."` = ".mysql_real_escape_string($value)."";
	                
                    if ($usegetMASQL == true) {
                    	if($query = $this->query($query)) {
                    		return mysql_fetch_object($query);
                    	} else {
                    		echo "Query Failed! on getMA";
                    	}
                    }
                    elseif ($useQuery == true) {
                    	$query = $this->query($query);
                    	return $query;
                    }
                    else {
                    	return $query;
                    }
                }
            }
        }
		else throw new Exception('You need to give all parameter!');
	}
	
	/**
	 * getArray() - Gets an Array from Table $table and where $row = $value
	 */
	
	public function getArray($table,$row , $value){
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