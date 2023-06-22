<?php

class DB
{
	private static $db = null;

	private function __construct() {}

	public static function getConnection() {

		if( DB::$db === null ) {
			
            try {
				$user = "student";
				$pass = "pass.mysql";
				$dbname = "petrinjak";

				DB::$db = new PDO(
					'mysql:host=rp2.studenti.math.hr;dbname=' . $dbname . ';charset=utf8',
					$user,
					$pass
				);
				DB::$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				DB::$db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				
			} catch (PDOException $e) {
				echo "Error when connecting to database: " . $e -> getMessage();
				exit();
			}
	    }
		return DB::$db;
	}
}

?>
