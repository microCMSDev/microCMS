<?php

namespace database;


class db
{
   function  __construct()
   {
	   //$this->dbConnect();
	   //$mcdb = new db();
   }
   
   /*
    * dbConnect
    * assigns variables from the sites config file (mc-config.php)
    * @DBHOST
    * @DBUSER
    * @DBPASS
    * @DBNAME
    *
    * It then attempts to connect to the mysql server
    * used throughout the db class
    * Since 1.4
    *
    * Usage: $conn->$this->dbConnect()
   */
   private function dbConnect()
   {
      $this->dbHost = DBHOST;
      $this->dbUser = DBUSER;
      $this->dbPass = DBPASS;
      $this->dbName = DBNAME;
		
      // Try to connect
      $this->conn = mysqli_connect($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
		
      // Test if connection succeeded
      if (mysqli_connect_errno())
      {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
      else
      {
         return $this->conn;
      }
   }
	
	/*
	 * Let us be good secure stewards
	 * always close the connection after a query
	*/
	private function closeConnection()
	{
		mysqli_close($this->conn);
	}
	
	/*
	 * Does all MySQLi queries
	 * utilizing conn from dbConnect()
	 * $string is sent from the page to this function
	 * on the page, use: $query = "YOUR QUERY" then $db->query($query);
	*/
	public function query($string)
	{
		$conn = $this->dbConnect();
		$theQuery = mysqli_query($conn, $string);
		//$this->confirm_query($theQuery);
		
		return $theQuery;
		
		// Close the connection
		$this->closeConnection();
	}
	
	/* 
	 * Does associated fetch in MySQLi
	 * gets its $string from the page
	 *
	 * USAGE: $db->fetch_assoc($result);
	*/
	public function fetch_assoc($string)
	{
		$assoc = mysqli_fetch_assoc($string);
		return $assoc;
	}
	
	/* 
	 * Does array fetch in MySQLi
	 * gets its $string from the page
	 *
	 * USAGE: $db->fetch($result);
	*/
	public function fetch_array($string)
	{
		$array = mysqli_fetch_array($string);
		return $array;
	}
	
	/* 
	 * Does array num rows in MySQLi
	 * gets its $string from $result
	 *
	 * USAGE: $db->rows($result);
	*/
	public function rows($string)
	{
		$rows = mysqli_num_rows($string);
		return $rows;
	}
	
	/* 
	 * Does array real escape in MySQLi
	 * gets its $string from the page
	 *
	 * USAGE: $db->prep_data($string);
	*/
	public function prep_data($string)
	{
		$conn = $this->dbConnect();
		$escaped_string = mysqli_real_escape_string($conn, $string);
		return $escaped_string;
		$this->closeConnection();
	}
	
	public function email_lookup($email)
	{
		$query = "SELECT * FROM mc_users WHERE user_email = $email";
		$result = $this->query($query);
		$this->confirm_query($result);
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function user_lookup($username)
	{
		$query = "SELECT * FROM mc_users WHERE user_login = $username";
		$result = $this->query($query);
		$this->confirm_query($result);
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
