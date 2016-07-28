<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";

	//var_dump(LobbySQL::getInstance()->getLobby($_GET['id']))
	echo LobbySQL::getInstance()->getPlayersJson($_GET['id']);
?>