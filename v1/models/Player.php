<?php
	#   Author of the script
	#   Name: Ezra Adamu
	#   Email: ezra00100@gmail.com
	#   Date created: 10/10/2024 
	#   Date modified: 10/10/2024  

	include_once( 'Db.php' );
	//include_once( 'File.php' );

	class Player
	{
		//using Namespaces
		use Db {
      		Db::__construct as private __appConst;
    	}

		//use File;

		protected $table = '';
		private static $nigerian_states = [
											"Abia",
											"Adamawa",
											"Akwa Ibom",
											"Anambra",
											"Bauchi",
											"Bayelsa",
											"Benue",
											"Borno",
											"Cross River",
											"Delta",
											"Ebonyi",
											"Edo",
											"Ekiti",
											"Enugu",
											"Gombe",
											"Imo",
											"Jigawa",
											"Kaduna",
											"Kano",
											"Katsina",
											"Kebbi",
											"Kogi",
											"Kwara",
											"Lagos",
											"Nasarawa",
											"Niger",
											"Ogun",
											"Ondo",
											"Osun",
											"Oyo",
											"Plateau",
											"Rivers",
											"Sokoto",
											"Taraba",
											"Yobe",
											"Zamfara",
											"Federal Capital Territory (FCT)"
										];

		function __construct()
	 	{
	 		$this->__appConst();
	 		$this->table = DB_TABLE_PLAYER;
	 	}

		function getAll( array $dt ) 
		{
			$sql = "SELECT * FROM $this->table";
			$res = $this->fetchMultiple( $sql, $dt );

			return $res ?? [];
		}

		function getSearched( array $dt ) 
		{
			$searchTerm = '%' . $dt[0] . '%';

			$sql = "SELECT * FROM $this->table WHERE `full_name` LIKE ?";
			$res = $this->fetchMultiple($sql, [$searchTerm]);

			return $res ?? [];
		}

		function getById( array $dt ) 
		{
			$sql = "SELECT * FROM $this->table WHERE id = ?";
			$res = $this->fetchSingle( $sql, $dt );

			return $res ?? [];
		}

		public function getAllWithLimit($limit)
        {
            $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT ?";
            $res = $this->fetchmultiple($sql, [ $limit ]);
            
            return $res ?? [];
        }
		
		function deleteById( array $dt ) 
		{
			$sql = "DELETE FROM $this->table WHERE id = ?";
			$res = $this->runQuery( $sql, $dt );

			return $res ?? false;
		}

		function updateById( array $dt ) 
		{
			$sql = "UPDATE $this->table SET status = ? WHERE id = ?;";
			$res = $this->runQuery2( $sql, $dt );

			return $res ?? false;
		}

		function addNew( array $dt ) 
		{
			$sql = "INSERT INTO $this->table (`player_ref_No`, `full_name`, `email`, `dob`, `height`, `weight`, `position`, `j_num`, `state`, `season_stats` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$res = $this->runQuery( $sql, $dt );

			return $res ?? false;
		}
		
		function updatePlayer( array $dt ) 
		{
			$sql = "UPDATE $this->table SET `full_name`= ?, `email`= ?, `dob`= ?, `height`= ?, `weight`= ?, `position`= ?, `j_num`= ?, `state`= ?, `season_stats` = ?, `status` = ?, `img` = ?  WHERE id = ?";

			$res = $this->runQuery($sql, $dt);
			return $res ?? false;
		}
		
		function getCount( array $dt ) 
		{
			$sql = "SELECT COUNT(id) AS total FROM $this->table";
			$res = $this->fetchSingle( $sql, $dt );

			return $res['total'] ?? 0;
		}

		function getEmail(array $dt) {
			$sql = "SELECT email FROM $this->table WHERE email = ? ";
			$res = $this->runQuery2($sql, $dt);
			return $res ?? false;
		}

		function updateImg(array $dt) {
			$sql = "UPDATE $this->table SET `img`= ? WHERE `player_ref_No`= ? ";
			$res = $this->runQuery2($sql, $dt);
			return $res ?? false;
		}

		public function getRefNo(array $dt) {
			$sql = "SELECT id FROM $this->table WHERE player_ref_No = ?";
			$res = $this->runQuery2($sql, $dt);
			return $res ?? false;
		}

		function getMaxId(array $dt): array {
			$sql = "SELECT MAX(id) as ref_no FROM players";
			$res = $this->fetchSingle($sql, $dt);
			return $res ?? [];
		}

		public static function getState(){
            return self::$nigerian_states;
        }

		
	}
?>