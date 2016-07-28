<?php
	include "../includes/UserSQL.php";
	//2592000 = 1 month
	$active = UserSQL::getInstance()->getAllRecentUsers(30); //active in last 30 seconds
	$away = UserSQL::getInstance()->getAllRecentUsers(300);
	$offline = UserSQL::getInstance()->getAllRecentUsers(2592000);
	
	$newActive = array();
	$newAway = array();
	$newOffline = array();
	
	for($i=0;$i<count($active);$i++){
		array_push($newActive,$away[$i]["username"]);
	}
	for($i=0;$i<count($away);$i++){
		if(!in_array($away[$i]["username"],$newActive))
			array_push($newAway,$away[$i]["username"]);
	}
	for($i=0;$i<count($offline);$i++){
		if(!in_array($offline[$i]["username"],$newActive) && !in_array($offline[$i]["username"],$newAway))
			array_push($newOffline,$offline[$i]["username"]);
	}
	
	$result = array();
	array_push($result,$newActive);
	array_push($result,$newAway);
	array_push($result,$newOffline);
	
	echo json_encode($result);
?>