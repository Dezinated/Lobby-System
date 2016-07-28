<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/includes/SQL.php';

class GamesSQL extends SQL {
	
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
  
    public static function doesGameExist($name){
        $stmt = self::$dbh->prepare("SELECT COUNT(*) FROM games WHERE title = :title");
        $stmt->execute(array(
			"title" => $name
		));
		return $stmt->fetchColumn(0) > 0;
    }
  
  
    public static function getMaxPlayers($name){
        $stmt = self::$dbh->prepare("SELECT maxPlayers FROM games WHERE title = :title");
        $stmt->execute(array(
			"title" => $name
		));
		return $stmt->fetchColumn(0);
    }
  
    public static function getImage($name){
        $stmt = self::$dbh->prepare("SELECT img FROM games WHERE title = :title");
        $stmt->execute(array(
			"title" => $name
		));
		return $stmt->fetchColumn(0);
    }
  
    public static function getGames(){
        $stmt = self::$dbh->prepare("SELECT * FROM games");
        $stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    public static function getGamesJson(){
        return json_encode($this->getGames());
    }
  
}
?>