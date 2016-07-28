var started = true;

function getLobbyStartValue() {
  $.post("getStartValue.php?id="+lobbyID).done(function (data){
    if(!started && data != "0"){
      $(function() {
        console.log(data);
        $('#hostCode').val(data);
        Notify("Lobby started!", "Your "+game+ " lobby has started!", "../"+gameImg);
        $({blurRadius: 4}).animate({blurRadius: 0}, {
            duration: 1250,
            easing: 'linear', // or "linear"
                             // use jQuery UI or Easing plugin for more options
            step: function() {
                $('#hostCode').css({
                    "-webkit-filter": "blur("+this.blurRadius+"px)",
                    "filter": "blur("+this.blurRadius+"px)"
                });
            }
        });
    });
      started = true;
    }else{
      if(data == "0")
        started = false;
      else
        started = true;
    }
  });
}

function startLobby() {
    $.post("startLobby.php?id="+lobbyID);
}
                                               
function lobbyHeartbeat(){
	$.post("heartbeat.php?id="+lobbyID);
	updateLobbyPlayers();
    getLobbyStartValue();
}


function updateLobbyPlayers(){
  $.post("getUsers.php?id="+lobbyID).done(function (data){
    var players = JSON.parse(data);
    var newhtml = "";
    $.each(players, function(key, val){
      newhtml += '<div class="player">'+key+'</div>';
    });
    
    $("#players").html(newhtml);
  });
}

function Notify(titleText, bodyText, img) {
    if ('undefined' === typeof notification)
        return false;       //Not supported....
    var noty = new notification(
        titleText, {
            body: bodyText,
            dir: 'auto', // or ltr, rtl
            lang: 'EN', //lang used within the notification.
            tag: 'notificationPopup', //An element ID to get/set the content
            icon: img //The URL of an image to be used as an icon
        }
    );
    noty.onclick = function () {
        console.log('notification.Click');
    };
    noty.onerror = function () {
        console.log('notification.Error');
    };
    noty.onshow = function () {
        console.log('notification.Show');
    };
    noty.onclose = function () {
        console.log('notification.Close');
    };
    return true;
}