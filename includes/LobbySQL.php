<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/includes/SQL.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/includes/GamesSQL.php';

class LobbySQL extends SQL {
	
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

	public function createLobby($user, $game, $maxPlayers, $hostCode, $password){
		$stmt = self::$dbh->prepare("INSERT INTO lobby (host, game, maxPlayers, hostCode, password, timeCreated, players) VALUES (:host, :game, :maxPlayers, :hostCode, :password, :timeCreated, :players)");
		$stmt->execute(array(
			"host" => $user->getUsername(),
			"game" => $game,
			"maxPlayers" => $maxPlayers,
			"hostCode" => $hostCode,
			"password" => $password,
			"timeCreated" => time(),
			"players" => json_encode(array())
		));
		//echo $user->getUsername();
        return self::$dbh->lastInsertId();
	}
	
	public static function getLobbies() {
		$stmt = self::$dbh->prepare("SELECT id, host, game, maxPlayers, timeCreated FROM lobby WHERE started <> '1'");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getLobbiesJson() {
		return json_encode(self::getLobbies());
	}
	
	public static function getLobby($id) {
		$stmt = self::$dbh->prepare("SELECT * FROM lobby WHERE id = :id");
		$stmt->execute(array (
          "id" => $id
        ));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
  
    public static function getLobbyHost($id){
        $stmt = self::$dbh->prepare("SELECT host FROM lobby WHERE id = :id");
		$stmt->execute(array (
          "id" => $id
        ));
		return $stmt->fetchColumn(0);
    }
  
    public static function getLobbyHostCode($id){
        $stmt = self::$dbh->prepare("SELECT hostCode FROM lobby WHERE id = :id");
		$stmt->execute(array (
          "id" => $id
        ));
		return $stmt->fetchColumn(0);
    }
  
    public static function updatePlayers($players, $id) {
      $stmt = self::$dbh->prepare("UPDATE lobby SET players = :players WHERE id = :id");
      $stmt->execute(array(
        "players" => $players,
        "id" => $id
      ));
    }
  
    public static function getPlayers($id) {
        $seconds = 1.5;
        $cutOffTime = time() - $seconds; //If they haven't been online in a month
      
		$stmt = self::$dbh->prepare("SELECT players FROM lobby WHERE id = :id");
		$stmt->execute(array(
          "id" => $id
        ));
		$players = json_decode($stmt->fetchColumn(0), true);
        $newPlayers = array();
      
        foreach ($players as $k => $v) {
          if($v > $cutOffTime)
            $newPlayers[$k] = $v;
        }
        return $newPlayers;
    }
  
    public static function getPlayersJson($id) {
      return json_encode(self::getPlayers($id));
    }
  
    public static function countPlayers($id) {
      return sizeof(self::getPlayers($id));
    }
  
  
    public static function startLobby($id) {
      $stmt = self::$dbh->prepare("UPDATE lobby SET started = '1' WHERE id = :id");
      $stmt->execute(array(
        "id" => $id
      ));
    }
  
    public static function getStartValue($id) {
      $stmt = self::$dbh->prepare("SELECT started FROM lobby WHERE id = :id");
		$stmt->execute(array (
          "id" => $id
        ));
		return $stmt->fetchColumn(0);
    }
}

?>