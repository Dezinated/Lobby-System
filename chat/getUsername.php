<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	$user = new User();
	
	if($user->isLoggedIn())
		echo $user->getUsername();
	
?>