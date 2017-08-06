<?php  

/**
*  Class that connects to DB via PDO.
* Returns PDO db object
*/
class DBConnection
{
	private static $connection = null;

	
	public static function getConnection() {
	    if (self::$connection == null) {
			$paramsPath = ROOT . '/config/db_params.php';
			$params = include($paramsPath);

			self::$connection = new PDO("mysql:host={$params['host']};dbname={$params['dbname']}", $params['user'], $params['password']);
	    }

	    return self::$connection;
	}
}

?>