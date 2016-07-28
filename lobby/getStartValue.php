<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	$user = new User();

	if(LobbySQL::getInstance()->getStartValue($_GET['id'])){
      echo LobbySQL::getInstance()->getLobbyHostCode($_GET['id']);
    }else{
      echo "0";
    }
	//var_dump(LobbySQL::getInstance()->getPlayersJson($_GET['id']))
?>