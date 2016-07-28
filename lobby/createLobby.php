<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	$user = new User();

	$game = "Mario Party 2";
	//$game = $_POST['game'];
	$maxPlayers = "4";
	$serverIp = "1.1.1.1";
	$serverPort = "42042";
	$password = "harambe";
	
	if($user->isLoggedIn())
		echo LobbySQL::getInstance()->createLobby($user, $game, $maxPlayers, $serverIp, $serverPort, $password);
?>