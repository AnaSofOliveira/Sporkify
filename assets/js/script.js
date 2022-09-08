var currentPlaylist = [];
var shuffledPlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn; 
var timer; 

$(document).click(function(click) {
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev(".songId").val();

    console.log("playlistId: " + playlistId);
    console.log("songId: " + songId);

	$.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId})
	.done(function(error) {

		if(error != "") {
            console.log("." + error + ".");
			alert(error + "teste");
			return;
		}

		hideOptionsMenu();
		select.val("");
	});
});

function changeThemeMode(){
    $("body").toggleClass("dark"); 
    applyTheme();  
}

function applyTheme(){
    var dark = $("body").hasClass("dark"); 
    if(dark){
        $("#style").attr("href", "assets/css/darkTheme.css");
        $(".play img").attr("src", "assets/images/icons/dark/play.png");
        $(".shuffle img").attr("src", "assets/images/icons/dark/shuffle.png");
        $(".previous img").attr("src", "assets/images/icons/dark/previous.png");
        $(".pause img").attr("src", "assets/images/icons/dark/pause.png");
        $(".next img").attr("src", "assets/images/icons/dark/next.png");
        $(".repeat img").attr("src", "assets/images/icons/dark/repeat.png");
        $(".volume img").attr("src", "assets/images/icons/dark/volume.png");
        
        $(".trackCount .play").attr("src", "assets/images/icons/dark/play-white.png");
        $(".songCount .play").attr("src", "assets/images/icons/dark/play-white.png");
        $(".trackOptions .optionsButton").attr("src", "assets/images/icons/dark/more.png");
        $(".songOptions .optionsButton").attr("src", "assets/images/icons/dark/trash.png");

        $(".userOptions .trash").attr("src", "assets/images/icons/dark/trash.png");
        $(".userOptions .lock_close").attr("src", "assets/images/icons/dark/lock_close.png");
        $(".userOptions .lock_open").attr("src", "assets/images/icons/dark/lock_open.png");
        $(".userOptions .validate").attr("src", "assets/images/icons/dark/validate.png");

        $(".group span img").attr("src", "assets/images/icons/dark/search.png");

        $("#mode").html("Light Mode");

    }else{
        $("#style").attr("href", "assets/css/lightTheme.css");
        $(".play img").attr("src", "assets/images/icons/light/play.png");
        $(".shuffle img").attr("src", "assets/images/icons/light/shuffle.png");
        $(".previous img").attr("src", "assets/images/icons/light/previous.png");
        $(".pause img").attr("src", "assets/images/icons/light/pause.png");
        $(".next img").attr("src", "assets/images/icons/light/next.png");
        $(".repeat img").attr("src", "assets/images/icons/light/repeat.png");
        $(".volume img").attr("src", "assets/images/icons/light/volume.png");

        $(".trackCount .play").attr("src", "assets/images/icons/light/play-white.png");
        $(".songCount .play").attr("src", "assets/images/icons/light/play-white.png");
        $(".trackOptions .optionsButton").attr("src", "assets/images/icons/light/more.png");
        $(".songOptions .optionsButton").attr("src", "assets/images/icons/light/trash.png");

        $(".userOptions .trash").attr("src", "assets/images/icons/light/trash.png");
        $(".userOptions .lock_close").attr("src", "assets/images/icons/light/lock_close.png");
        $(".userOptions .lock_open").attr("src", "assets/images/icons/light/lock_open.png");
        $(".userOptions .validate").attr("src", "assets/images/icons/light/validate.png");

        $(".group span img").attr("src", "assets/images/icons/light/search.png");

        $("#mode").html("Dark Mode");
    }  
}

function updateEmail(emailClass){
    var emailValue = $("." + emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php", {email: emailValue, username: userLoggedIn})
    .done(function(response){
        $("." + emailClass).nextAll(".message").text(response);
    });
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2){
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php", 
        {oldPassword: oldPassword, 
        newPassword1: newPassword1, 
        newPassword2: newPassword2,          
        username: userLoggedIn})
    .done(function(response){
        $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}


function logout(){
    $.post("includes/handlers/ajax/logout.php", function(){
        location.reload();
    })
}


function openPage(url){

    if(timer != null){
        clearTimeout(timer);
    }
    
    if(url.indexOf("?") == -1){
        url = url + "?";
    }
    
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function removeFromPlaylist(button, playlistId){
    var songId = $(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId})
    .done(function(error){

        if(error != ""){
            alert(error);
            return;
        }
        openPage("playlist.php?id=" + playlistId);
    })

}

function createPlaylist(){
    var popup = prompt("Please enter the name of your playlist");

    if(popup != null){
        $.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn})
        .done(function(error){

            if(error != ""){
                alert(error);
                return;
            }
            openPage("yourMusic.php");
        })
    }
}

function deletePlaylist(playlistId){
    var prompt = confirm("Are you sure you want to delete this playlist?");

    if(prompt){
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId})
        .done(function(error){

            if(error != ""){
                alert(error);
                return;
            }
            openPage("yourMusic.php");
        })
    }
}

function removeSongFromDB(button){

    var prompt = confirm("Are you sure you want to delete this song?");

	var songId = $(button).prevAll(".songId").val();

    if(prompt){
        $.post("includes/handlers/ajax/deleteSong.php", {songId: songId})
        .done(function(error){

            if(error != ""){
                alert(error);
                return;
            }
            openPage("removeSongDetails.php");
        })
    }
}

function removeUserFromDB(button){
    var prompt = confirm("Are you sure you want to delete this user?");

	var userId = $(button).prevAll(".userId").val();

    if(prompt){
        $.post("includes/handlers/ajax/deleteUser.php", {userId: userId})
        .done(function(error){

            if(error != ""){
                alert(error);
                return;
            }
            openPage("manageUserDetails.php");
        })
    }

}

function changePermission(button, role){
    var userId = $(button).prevAll(".userId").val();

    console.log("UserId: " + userId);
    console.log("Role: " + role);

    var prompt;
    if(role != "admin"){
        prompt = confirm("Are you sure you want this user to be an administrator?");
    }else{
        prompt = confirm("Do you want to remove the admnistrator functions from this user?");
    }

    if(prompt){
        $.post("includes/handlers/ajax/updateRole.php", {userId: userId, role: role})
        .done(function(error){

            if(error != ""){
                alert(error);
                return;
            }
            openPage("manageUserDetails.php");
        })
    } 

}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button) {
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
	var elementOffset = $(button).offset().top; //Distance from top of document

	var top = elementOffset - scrollTop;
	var left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}

function formatTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : ""; 

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress_percentage = audio.currentTime / audio.duration * 100;
    
    $(".playbackBar .progress").css("width", progress_percentage + "%");
    
}

function updateVolumeProgressBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong(){
    setTrack(tempPlaylist[0], tempPlaylist, true);
}


function Audio(){

    this.currentlyPlaying;
    this.audio = document.createElement("audio"); 

    this.audio.addEventListener("ended", function(){
        nextSong();
    });

    this.audio.addEventListener("canplay", function(){
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });

    this.audio.addEventListener("timeupdate", function(){
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.setTrack = function(track){
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    } 

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }

}