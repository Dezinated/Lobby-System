<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	$user = new User();

    if(!$user->isLoggedIn())
      die();

	$lobby = LobbySQL::getInstance()->getLobby($_GET['id']);
    $players = json_decode($lobby['players'], true);
    var_dump($players);
    $players[$user->getUsername()] = time();
    
    LobbySQL::getInstance()->updatePlayers(json_encode($players), $_GET['id']);
?>