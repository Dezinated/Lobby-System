<?php
	include $_SERVER["DOCUMENT_ROOT"]."/includes/User.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/LobbySQL.php";
	$user = new User();

	$lobby = LobbySQL::getInstance()->getLobby($_GET['id']);
	//var_dump(LobbySQL::getInstance()->getPlayersJson($_GET['id']))
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../reset.css">
    <link rel="stylesheet" type="text/css" href="../theme.css">
    <link rel="stylesheet" type="text/css" href="../lobby.css">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
    <script>
      <?php
        echo "\tvar lobbyID=".htmlspecialchars($_GET['id']).";\n\t\t";
        echo "var game='".$lobby['game']."';\n\t\t";
        echo "var gameImg='".file_get_contents('http://'.$_SERVER["HTTP_HOST"].'/lobby/getGameImage.php?name='.urlencode($lobby['game']))."';";
      ?>
    </script>
  </head>

  <body>
    <div class="pageContainer">
      <div id="lobbyPage">
        <div class="box">
          <div class="boxTitle">
            <h2><?= $lobby['game'] ?> Lobby ~ <?= $lobby['host'] ?></h2>
          </div>
          <div class="boxContent">



            <div id="chatBox">
              <div class="titleBar">
                <h2>Chat</h2></div>
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
                <input type="image" src="../img/send-button.svg" alt="button" onclick="sendMessage()" />
                </span>
              </div>
            </div>


            <div id="side">

              <div id="optionsBox">
                <div class="titleBar">
                  <h2>   </h2></div>
                <div id="serverInfo">
                  HOST CODE: <input type="text" id="hostCode" value="fuckyou" disabled />
                </div>
                <div id="options">
                  <ul>
                    <?php
                      if($lobby['host'] == $user->getUsername()){
                        echo '<li>Kick player</li>';
                        echo '<li onclick="startLobby()">Start game</li>';
                      }
                    ?>    
                  </ul>
                </div>
              </div>
              
              <div id="playersBox">
                <div class="titleBar">
                  <h2>Players</h2></div>
                <div id="players">
                  <ul>
                  </ul>
                </div>
              </div>
              
            </div>

          </div>
        </div>
      </div>
    </div>


    <script src="../js/lobby.js"></script>
    <script src="../js/inLobby.js"></script>
    <script src="../js/lobbyChat.js"></script>
    <script>
      var heartbeat;
      var resetChat;
      $(document).ready(function() {
        setChatBox();
        heartbeat = setInterval(function() {
          lobbyHeartbeat();
        }, 125);
        resetChat = setInterval(function(){ setChatBox(); }, 100);
        getUsername();
      });
      
      var notification = window.Notification || window.mozNotification || window.webkitNotification;
      notification.requestPermission(function(permission){});
    </script>
  </body>

  </html>