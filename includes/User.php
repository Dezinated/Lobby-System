<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/UserSQL.php";

if (!isset($errors)) {
    $errors = array();
}

class User {
	protected $username;
	protected $password;
	protected $info;
	
	public function __construct(){
		session_start();
		if($this->isLoggedIn()){
			$info = UserSQL::getInstance()->getInfo($_SESSION['username']);
			$this->username = $info['username'];
			$this->password = $info['password'];
		}
	}
	
	public function heartbeat(){
		if($this->isLoggedIn()){
			UserSQL::getInstance()->heartbeat($this->getUsername());
		}
	}
	
	public function login($username,$password){
		if($this->isLoggedIn())
			return false;
		if(UserSQL::getInstance()->validateLogin($username,$password)){
			$info = UserSQL::getInstance()->getInfo($username);
			$_SESSION['id'] = $info['id'];
			$_SESSION['username'] = $info['username'];
			return true;
		}
		return false;
	}
	
	public function logout(){
		unset($_SESSION);
		session_destroy();
	}
	
	public function isLoggedIn(){
		if(isset($_SESSION['id'])){
			return true;
		}
		return false;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function getPassword(){
		return $password;
	}
}
?>