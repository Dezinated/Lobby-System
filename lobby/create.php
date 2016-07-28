<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/GamesSQL.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
$user = new User();

if(!$user->isLoggedIn()){
  header("Location ./index.php");
}
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
          <h1>Create Lobby</h1>

          <?php
                $hostCode = "";
                $password = "";
                $maxPlayers = "";
                  
                if(!empty($_POST)){
                  if(!GamesSQL::getInstance()->doesGameExist($_POST['game'])){
                    echo '<div class= "login-error">Game does not exist</div>';
                  }else if($_POST['maxPlayers'] > GamesSQL::getInstance()->getMaxPlayers($_POST['game'])){
                    echo '<div class= "login-error">Max players cannot be over game\'s max player limit</div>';
                  }else if($_POST['maxPlayers'] <= 0){
                    echo '<div class= "login-error">Enter a correct value for max players</div>';
                  }else if(empty($_POST['hostCode'])){
                    echo '<div class= "login-error">Enter a host code</div>';
                  }else if(empty($_POST['maxPlayers'])){
                    echo '<div class= "login-error">Enter a value for max players</div>';
                  }else{
                    $id = LobbySQL::getInstance()->createLobby($user, $_POST['game'], $_POST['maxPlayers'], $_POST['hostCode'], $_POST['password']);
                    echo '<div class= "login-success">Lobby created, redirecting to lobby</div>';
                    echo '<meta http-equiv="refresh" content="1;url=http://'.$_SERVER["HTTP_HOST"].'/lobby/lobby.php?id='.$id.'">';
                  }
                  
                  $hostCode = $_POST['hostCode'];
                  $password = $_POST['password'];
                  $maxPlayers = $_POST['maxPlayers'];
                }
            ?>

            
            <input type="text" placeholder="Host Code" name="hostCode"  value="<?= $hostCode ?>"/>
            <input type="text" placeholder="Password" name="password"  value="<?= $password ?>"/>
            <select name="game">
              <?php
                $games = GamesSQL::getInstance()->getGames();
                for($i=0;$i<sizeof($games);$i++){
                  echo '<option value="'.$games[$i]["title"].'">'.$games[$i]["title"].'</option>';
                }
              ?>
            </select>
            <input type="number" placeholder="Max Players" name="maxPlayers" min="1" max="4" value="<?= $maxPlayers ?>"/>
            <input type="submit" value="CREATE" />
        </div>
      </form>
    </div>
  </body>

  </html>