<?php
abstract class SQL {
	private static $instance;
	public static $dbh = null;
	public static $dbname = "chat";
	
	public function __construct() {
        $user = "root";
		$pass = "harambe420";
		try {
			self::$dbh = new PDO('mysql:host=localhost;dbname='.self::$dbname, $user, $pass);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
    }

	public function setDB($name){
		self::$dbname = $name;
	}

	public function printAll($table){
		foreach(self::$dbh->query('SELECT * from '.$table) as $row) {
			print_r($row);
		}
	}
	
	
}
?>