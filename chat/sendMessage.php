<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/ChatSQL.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	$user = new User();
	
	if($user->isLoggedIn() && !empty($_POST['message']) && !empty($_POST['to'])){
		$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(empty($_GET['id'])){
          $_GET['id'] = 0;
        }
		ChatSQL::getInstance()->addMessage($user->getUsername(),$_POST['to'],$_POST['message'],$_GET['id']);
	}
?>