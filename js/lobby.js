function getLobbies() {
  return $.ajax({
    url: "lobby/getLobbies.php"
  });
}

function getGame() {
  return $.ajax({
    url: "lobby/getLobbies.php"
  });
}

function setLobby() {
  var lobbyPromise = getLobbies();
  var newMessage = "";
  lobbyPromise.success(function (data) {
      data = JSON.parse(data);
      for (i = 0; i < data.length; i++) {
        newMessage += '<div class="lobby">';
        newMessage += '<span class="pic">';
        newMessage += '<img src="'+data[i]["img"]+'" />';
        newMessage += '</span>';
        newMessage += '<span class="infoArea">';
        newMessage += '<div class="game">'+data[i]["game"]+'</div>';
        newMessage += '<div class="host">'+data[i]["host"]+'</div>';
        newMessage += '<div class="numOfPlayers">'+data[i]["amountOfPlayers"]+'/'+data[i]["maxPlayers"]+' Players</div>';
        newMessage += '</span>';
        newMessage += '<span class="joinButton">';
        newMessage += '<a href="lobby/lobby.php?id='+data[i]["id"]+'">';
        newMessage += 'Join';
        newMessage += '</a>';
        newMessage += '</span>';
        newMessage += '</div>';
      }
    $("#lobbys").html(newMessage);
    });
  }
