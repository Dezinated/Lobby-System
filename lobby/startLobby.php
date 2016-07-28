<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	$user = new User();

    if($user->isLoggedIn()) {
      if($user->getUsername() == LobbySQL::getInstance()->getLobbyHost($_GET['id']))
        LobbySQL::getInstance()->startLobby($_GET['id']);
    }
	 //
	//var_dump(LobbySQL::getInstance()->getPlayersJson($_GET['id']))
?>