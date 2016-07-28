<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	$user = new User();
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" type="text/css" href="theme.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
  </head>

  <body>

    <div id="header">
      <h1>Site</h1>
      <div id="user-info">
        <ul>
          <?php
			if($user->isLoggedIn()){
				echo '<li>'.$user->getUsername().'</li>';
                echo '<a href="account/settings.php"><li><i class="fa fa-cog" aria-hidden="true"></i></li></a>';
                echo '<a href="account/logout.php"><li><i class="fa fa-sign-out" aria-hidden="true"></i></li></a>';
			}else{
				echo '<a href="account/login.php"><li>Login</li></a>';
				echo '<a href="account/register.php"><li>Register</li></a>';
			}
		  ?>


        </ul>
      </div>
    </div>

    <div class="pageContainer">
      <aside>

        <div id="playersBox">
          <div class="box">
            <div class="boxTitle">
              <h2>Players</h2>
              <div id="search">
                <i class="fa fa-search" aria-hidden="true"></i>
              </div>
            </div>
            <div class="boxContent">
              <div id="players">
              </div>
            </div>
          </div>
        </div>

        <div id="chatBox">
          <div class="box">
            <div class="boxTitle">
              <h2>Chat</h2>
            </div>
            <div class="boxContent noPadding">
              <div id="chatArea">
                <div class="message">
                  <span class="timestamp"></span><span class="user">Username</span>:
                  <p class="text"> Message</p>
                </div>
              </div>
              <div id="sendMessage">
                <span id="sendMessageText">
                  <textarea id="newMessageText" name="message"></textarea>
                </span>
                <span id="sendButton">
                <input type="image" src="img/send-button.svg" alt="button" onclick="sendMessage()" />
                </span>
              </div>
            </div>
          </div>
        </div>

      </aside>
      <main>

        <div id="lobbyBox">
          <div class="box">
            <div class="boxTitle">
              <h2>Lobby</h2>
            </div>
            <div class="boxContent">

              <?php
              if($user->isLoggedIn()){
                
                echo '<div class="lobby">
                      <span class="createLobby"><a href="lobby/create.php"><b>+</b> Create a lobby</a></span>
                      </div>';
              }
            ?>

                <div id="lobbys">

                </div>
            </div>
          </div>
        </div>
      </main>

      <div id="formBox" class="createBox">
         <h1>Create Lobby</h1>
        <input type="text" placeholder="Host Code" name="hostCode" value="<?= $hostCode ?>" />
        <input type="text" placeholder="Password" name="password" value="<?= $password ?>" />
        <select name="game">
          <?php
                /*$games = GamesSQL::getInstance()->getGames();
                for($i=0;$i<sizeof($games);$i++){
                  echo '<option value="'.$games[$i]["title"].'">'.$games[$i]["title"].'</option>';
                }*/
              ?>
        </select>
        <input type="number" placeholder="Max Players" name="maxPlayers" min="1" max="4" value="<?= $maxPlayers ?>" />
        <input type="submit" value="CREATE" />
        <input type="button" value="CANCEL" />
      </div>

    </div>



    <script src="js/chat.js"></script>
    <script src="js/lobby.js"></script>
    <script src="js/heartbeat.js"></script>
    <script>
      var resetChat;
      var resetLobby;
      $(document).ready(function() {
        setChatBox();
        heartbeat();
        resetChat = setInterval(function() {
          setChatBox();
        }, 100);
        resetLobby = setInterval(function() {
          setLobby();
        }, 500);
        getUsername();
      });
    </script>
  </body>

  </html>