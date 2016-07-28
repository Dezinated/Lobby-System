var username;

$('#newMessageText').keypress(function (e) {
	if(e.which == 13) { //enter
		sendMessage();
	}
});

function sendMessage() {
	var sendTo = "chat";
	var sendMessage = $("#newMessageText").val();
	$("#newMessageText").attr("disabled", true);
	if($("#newMessageText").val().substring(0, 1) == "@"){
		sendTo = $("#newMessageText").val().split(" ")[0].substring(1);
		sendMessage = $("#newMessageText").val().substring($("#newMessageText").val().indexOf(" "));
	}
	$.post("chat/sendMessage.php", { to: sendTo, message: sendMessage }).done(function( data ) {
		$("#newMessageText").val("");
		setChatBox();
		$("#newMessageText").attr("disabled", false);
	});
}

function getUsername(){
	$.post("chat/getUsername.php").done(function( data ) {
		username = data;
	});
}

function getMessages(){
	return $.ajax({
		url: "chat/getMessages.php"
	});
}

function setChatBox(){
	var messagePromise = getMessages();
	var newMessage = "";
	
	messagePromise.success(function (data) {
		data = JSON.parse(data);
		for (i = data.length-1; i >= 0; i--) { 
			var time = convertTime(data[i]["timestamp"]);
			if(data[i]["sentTo"] == username){
				newMessage += '<div class="message dm">';
				newMessage += '<span class="timestamp">['+time+']</span> (from <span onclick="dm(this)" class="user">' +data[i]["sentBy"]+ '</span>)<span class="text">: ' +data[i]["message"]+ '</span>';
			}else if(data[i]["sentTo"] != "chat"){
				newMessage += '<div class="message dm">';
				newMessage += '<span class="timestamp">['+time+']</span> (to <span onclick="dm(this)" class="user">' +data[i]["sentTo"]+ '</span>)<span class="text">: ' +data[i]["message"]+ '</span>';
			}else{
				newMessage += '<div class="message">';
				newMessage += '<span class="timestamp">['+time+']</span> <span onclick="dm(this)" class="user">' +data[i]["sentBy"]+ '</span><span class="text">: ' +data[i]["message"]+ '</span>';
			}
			
			newMessage += '</div>';
		}
		if($("#chatArea").html() != newMessage){
			console.log("Updating chat");

			$("#chatArea").html(newMessage);
			$('#chatArea').scrollTop($('#chatArea')[0].scrollHeight);
		}
		//$("#chatArea").html(newMessage);
	});
}

function dm(element){
	var user = $(element).html();
	if($("#newMessageText").val().substring(0, 1) == "@"){
		$("#newMessageText").val("@"+user+" "+$("#newMessageText").val().substring($("#newMessageText").val().indexOf(" ")+1));
	}else{
		$("#newMessageText").val("@"+user+" "+$("#newMessageText").val());
	}
	$("#newMessageText").focus();
}

function convertTime(time){
	var difference = (new Date().getTime() / 1000)-time;
	if(difference > 60*525600) { //1 year
		var date = new Date(time*1000);
		return date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getYear();
	}
	if(difference > 86400) { //1 day
		var date = new Date(time*1000);
		return date.getDate() + "/" + (date.getMonth()+1);
	}
	if(difference > 3600) { //1 hour
		return Math.round(difference/3600)+"h";
	}
	if(difference > 60) { //60 seconds
		return Math.round(difference/60)+"m";
	}
	return "now";
	
	//var now = new Date(unix_timestamp*1000);
	console.log(difference);
}