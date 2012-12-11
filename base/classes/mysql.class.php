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
				return $result;
			}
		}
		else throw new Exception('You need to give all parameter!');
	}
	
	/**
	 * getArray() - Gets an Array from Table $table and where $row = $value, 
	 * Can user multiple aruments like getArray('table','id',5,'name','miner345',...)
	 */
	
	public function getArray($table, $row, $value){
		if(isset($table)){
			if(mysql_query('SELECT * FROM `'.$table.'`')){ # Checks if table exists
				$array = func_get_args();
				$count = (count($array)-1) / 2 -1;
				$query = "SELECT * FROM `".$table."` WHERE";
				for($i=0;$i<=$count;$i++){
					$row = $array[$i*2+1];
					$value = $array[$i*2+2];
					if($i==0){
						if(gettype($value)=="string"){ # Checks the type for different querys
							$query .= " `".$row."` = '".$value."'";
						}
						elseif(gettype($value)=="integer" || gettype($value)=="double"){
							$query .= " `".$row."` = ".$value."";
						}
					}
					elseif($i>=1){
						if(gettype($value)=="string"){ # Checks the type for different querys
							$query .= " AND `".$row."` = '".$value."'";
						}
						elseif(gettype($value)=="integer" || gettype($value)=="double"){
							$query .= " AND `".$row."` = ".$value."";
						}
					}
					else throw new Exception('Query failed!');
					
				}
				$result = $this->query($query);
				if(!$result) return false;
				else {
					$array = mysql_fetch_array($result);
					return $array;
				}
			}
			else throw new Exception('Table not found!');
		}
		else throw new Exception('You need to give all parameter!');
	}
}
?>