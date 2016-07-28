<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/GamesSQL.php";

	print_r(LobbySQL::getInstance()->getLobbiesJson());
?>