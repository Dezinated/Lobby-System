<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/GamesSQL.php";

	print_r(GamesSQL::getInstance()->getImage($_GET['name']));
?>