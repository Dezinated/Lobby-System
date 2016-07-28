<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/GamesSQL.php";

	$lobbies = LobbySQL::getInstance()->getLobbies();
    for($i=0;$i<sizeof($lobbies);$i++){
      $lobbies[$i]["img"] = GamesSQL::getInstance()->getImage($lobbies[$i]["game"]);
      $lobbies[$i]["amountOfPlayers"] = LobbySQL::getInstance()->countPlayers($lobbies[$i]["id"]);
    }
  print_r(json_encode($lobbies));
?>