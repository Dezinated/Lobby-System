<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
$user = new User();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../reset.css">
	<link rel="stylesheet" type="text/css" href="../theme.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>
<body>

	<div class="pageContainer">
		<form method="POST">
            <div id="loginBox">
                <h1>Member Login</h1>
              
                <?php
                  if($user->isLoggedIn()){
                      echo '<div class= "login-error">You are already logged in</div>';
                      die();
                  }
                  if(!empty($_POST)){
                      if($user->login($_POST['username'],$_POST['password'])){
                          echo '<div class= "login-success">Logged in</div>';
                      }else{
                          echo '<div class= "login-error">Wrong password</div>';
                      }
                  }
                ?>
                
                <input type="text" placeholder="Username" name="username" />
                <input type="password" placeholder="Password" name="password" />
                <input type="submit" value="LOGIN" />
            </div>
		</form>
	</div>
</body>
</html>