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
            <div id="formBox" class="registerBox">
                <h1>Member Login</h1>
              
                <?php
                  if($user->isLoggedIn()){
                      echo '<div class= "login-error">You are already logged in</div>';
                      die();
                  }

                if(!empty($_POST)){
                    if(!UserSQL::getInstance()->doesUserExist($_POST['username'])){
                        UserSQL::getInstance()->addUser($_POST['username'],$_POST['password'],$_POST['email']);
                        echo '<div class= "login-success">Registered, redirecting to login</div>';
                        echo '<meta http-equiv="refresh" content="1;url=http://'.$_SERVER["HTTP_HOST"].'/account/login.php">';
                    }else{
                        echo '<div class= "login-error">Register failed</div>';
                    }
                }
                ?>
                
                <input type="text" placeholder="Username" name="username" />
                <input type="text" placeholder="Email" name="email" />
                <input type="password" placeholder="Password" name="password" />
                <input type="password" placeholder="Confirm Password" name="password2" />
                <input type="submit" value="LOGIN" />
            </div>
		</form>
	</div>
</body>
</html>