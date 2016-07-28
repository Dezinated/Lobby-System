<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
$user = new User();

$user->logout();
header('Location: http://'.$_SERVER['HTTP_HOST']);
?>