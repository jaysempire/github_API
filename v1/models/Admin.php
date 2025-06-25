<?php
	#   Author of the script
	#   Name: Ezra Adamu
	#   Email: ezra00100@gmail.com
	#   Date created: 10/10/2024 
	#   Date modified: 10/10/2024  

	include_once( 'Db.php' );
	include_once( 'Encryption.php' );

	class Admin
	{
		//using Namespaces
		use Db {
      		Db::__construct as private __appConst;
    	}

		use Encryption;

		protected $table = '';

		function __construct()
	 	{
	 		$this->__appConst();
	 		$this->table = DB_TABLE_ADMIN;
	 	}

		function login( array $dt ) 
		{
			$sql = "SELECT * FROM $this->table WHERE ( user_name = ? OR email = ? )";
			$res = $this->fetchSingle( $sql, $dt );

			return $res ?? [];
		}
		
		function getByTokenLogin( array $dt ) 
		{
			$sql = "SELECT * FROM $this->table WHERE token_login = ?";
			$res = $this->fetchSingle( $sql, $dt );
			
			return $res ?? [];
		}

      function updateTokenLoginById( array $dt ) 
		{	
			$sql = "UPDATE $this->table SET token_login = ? WHERE id = ?";
			$res = $this->runQuery2( $sql, $dt );
			
			return $res ?? false;
		}
      function updateTokenLogoutById( array $dt ) 
		{	
			$sql = "UPDATE $this->table SET token_login = ? WHERE token_login = ?";
			$res = $this->runQuery2( $sql, $dt );
			
			return $res ?? false;
		}

		function getLoggedAdmin()
		{
			return $_COOKIE[ APP_SESS ] ?? 0;
		}

	}
?>