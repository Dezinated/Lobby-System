<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/ChatSQL.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	$user = new User();
	
	//if($user->isLoggedIn())
        if(empty($_GET['id'])){
          $_GET['id'] = 0;
        }
		echo ChatSQL::getInstance()->getMessagesJson($user,$_GET['id']);
?>