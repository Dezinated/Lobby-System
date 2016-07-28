<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/includes/SQL.php';

class UserSQL extends SQL {
	
	private static $instance;
	
	public function __construct() {
		self::setDB("main");
		parent::__construct();
	}
	
	public static function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public static function doesUserExist($username){
		$stmt = self::$dbh->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute(array(
			"username" => $username,
		));
		return $stmt->fetchColumn(0) > 0;
	}
	
	public static function getInfo($username){
		$stmt = self::$dbh->prepare("SELECT * FROM users WHERE username = :username");
		$stmt->execute(array(
			"username" => $username,
		));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function validateLogin($username, $password){
		$result = self::getInfo($username);
		if($result['password'] == $password)
			return true;
	}
	
	public function addUser($username, $password, $email){
		$stmt = self::$dbh->prepare("INSERT INTO users (username, password, email, signUpDate) VALUES (:username, :password, :email, :timestamp)");
		$stmt->execute(array(
			"username" => $username,
			"email" => $email,
			"password" => $password,
			"timestamp" => time()
		));
	}
	
	public static function heartbeat($username){
		$stmt = self::$dbh->prepare("UPDATE users SET lastOnline='".time()."' WHERE username=:username");
		$stmt->execute(array(
          "username" => $username
        ));
	}
	
	
	
	public static function getAllUsers(){
		
	}
	
	public static function getAllRecentUsers($seconds){ // !!!!!!!!!!!!!!! POSSIBLE SQLI !!!!!!!!!!!!!!!!!
		$cutOffTime = time() - $seconds; //If they haven't been online in a month
		$stmt = self::$dbh->prepare("SELECT username FROM users WHERE lastOnline > '".$cutOffTime."' ORDER BY username");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	
}
?>