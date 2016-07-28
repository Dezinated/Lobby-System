<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/includes/SQL.php';

class ChatSQL extends SQL {
	
	private static $instance;
	
	public function __construct() {
		self::setDB("chat");
		parent::__construct();
	}
	
	public static function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public static function addMessage($sentBy, $sentTo, $message, $lobby){
		str_replace(array("\r", "\n"), '', $message);
		$stmt = self::$dbh->prepare("INSERT INTO messages (sentBy, sentTo, timestamp, message, lobby) VALUES (:sentBy, :sentTo, :timestamp, :message, :lobby)");
		$stmt->execute(array(
			":sentBy" => $sentBy,
			":sentTo" => $sentTo,
			":timestamp" => time(),
			":message" => $message,
			":lobby" => $lobby
		));
	}
	
	public static function getMessages($user, $lobbyID){
		if($user->isLoggedIn()){
            if($lobbyID == 0){
              $stmt = self::$dbh->prepare("SELECT * FROM messages WHERE (sentTo='chat' AND lobby = :lobbyID) OR ((sentBy='".$user->getUsername()."' OR sentTo='".$user->getUsername()."') AND lobby = :lobbyID)  ORDER BY timestamp DESC LIMIT 60");
            }else{
              $stmt = self::$dbh->prepare("SELECT * FROM messages WHERE lobby = :lobbyID ORDER BY timestamp DESC LIMIT 60");
            }
        }else{
			$stmt = self::$dbh->prepare("SELECT * FROM messages WHERE sentTo='chat' AND lobby = :lobbyID ORDER BY timestamp DESC LIMIT 60");
        }
      
        $stmt->execute(array(
          ":lobbyID" => $lobbyID
        ));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getMessagesJSON($user, $lobbyID){
		return json_encode(self::getMessages($user, $lobbyID));
	}
	
}
?>