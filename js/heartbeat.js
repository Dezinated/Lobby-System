var interval = null;

$(window).on("blur focus", function(e) {
    var prevType = $(this).data("prevType");

    if (prevType != e.type) {   //  reduce double fire issues
        switch (e.type) {
            case "blur":
                clearInterval(interval);
                break;
            case "focus":
				heartbeat();
                interval = setInterval(heartbeat,1500);
                break;
        }
    }

    $(this).data("prevType", e.type);
})

function heartbeat(){
	$.post("account/heartbeat.php");
	updatePlayers();
}

function updatePlayers(){
	$.post("account/getUsers.php").done(function (data){
		data = JSON.parse(data);
		var newHTML = "";
		for (i=0; i<data[0].length; i++) { 
			newHTML += "<div class='player'><span class='status online'></span><span onclick='dm(this)' class='playerName'>"+data[0][i]+"</span></div>";
		}
		for (i=0; i<data[1].length; i++) { 
			newHTML += "<div class='player'><span class='status away'></span><span onclick='dm(this)' class='playerName'>"+data[1][i]+"</span></div>";
		}
		for (i=0; i<data[2].length; i++) { 
			newHTML += "<div class='player'><span class='status offline'></span><span onclick='dm(this)' class='playerName'>"+data[2][i]+"</span></div>";
		}
		$("#players").html(newHTML);
	});
}