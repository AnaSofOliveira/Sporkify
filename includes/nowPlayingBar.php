<?php 

    $song_query = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    
    $resutlArray = array();
    while($row = mysqli_fetch_array($song_query)){
        array_push($resutlArray, $row['id']);
    }

    $jsonArray = json_encode($resutlArray);
?>

<script>

	$(document).ready(function() {

		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);


		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
			e.preventDefault();
		});


		$(".playbackBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e) {
			if(mouseDown == true) {
				//Set time of song, depending on position of mouse
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e) {
			timeFromOffset(e, this);
		});


		$(".volumeBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e) {
			if(mouseDown == true) {

				var percentage = e.offsetX / $(this).width();

				if(percentage >= 0 && percentage <= 1) {
					audioElement.audio.volume = percentage;
				}
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e) {
			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		});

		$(document).mouseup(function() {
			mouseDown = false;
		});




	});

	function timeFromOffset(mouse, progressBar) {
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
	}

	function prevSong() {
		if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
			audioElement.setTime(0);
		}
		else {
			currentIndex = currentIndex - 1;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}

	function nextSong() {

		if(repeat == true) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length - 1) {
			currentIndex = 0;
		}
		else {
			currentIndex++;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function setRepeat() {
		repeat = !repeat;
		var imageName = repeat ? "repeat-active.png" : "repeat.png";

		var dark = $("body").hasClass("dark"); 
    	if(dark){
			$(".controlButton.repeat img").attr("src", "assets/images/icons/dark/" + imageName);
		}else{			
			$(".controlButton.repeat img").attr("src", "assets/images/icons/light/" + imageName);
		}
	}

	function setMute() {
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		
		var dark = $("body").hasClass("dark"); 
    	if(dark){
			$(".controlButton.volume img").attr("src", "assets/images/icons/dark/" + imageName);
		}else{
			$(".controlButton.volume img").attr("src", "assets/images/icons/light/" + imageName);
		}
	}

	function setShuffle() {
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";

		var dark = $("body").hasClass("dark"); 
    	if(dark){
			$(".controlButton.shuffle img").attr("src", "assets/images/icons/dark/" + imageName);
		}else{
			$(".controlButton.shuffle img").attr("src", "assets/images/icons/light/" + imageName);
		}

		if(shuffle == true) {
			//Randomize playlist
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else {
			//shuffle has been deactivated
			//go back to regular playlist
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}

	}

	function shuffleArray(a) {
		var j, x, i;
		for (i = a.length; i; i--) {
			j = Math.floor(Math.random() * i);
			x = a[i - 1];
			a[i - 1] = a[j];
			a[j] = x;
		}
	}


	function setTrack(trackId, newPlaylist, play) {

		if(newPlaylist != currentPlaylist) {
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}

		if(shuffle == true) {
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		else {
			currentIndex = currentPlaylist.indexOf(trackId);
		}
		pauseSong();

		$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
			console.log("includes/handlers/ajax/getSongJson.php: ", data);
			
			var track = JSON.parse(data);
			$(".trackName span").text(track.title);

			$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
				console.log("includes/handlers/ajax/getArtistJson.php: ", data);
				
				var artist = JSON.parse(data);
				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
			});

			$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
				console.log("includes/handlers/ajax/getAlbumJson.php: ", data);
				
				var album = JSON.parse(data);
				$(".content .albumLink img").attr("src", album.artworkPath);
				$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			});

			audioElement.setTrack(track);

			if(play == true) {
				playSong();
			}
		});

		
	}

	function playSong() {

		if(audioElement.audio.currentTime == 0) {
			$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
		}

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong() {
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
	}

</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" class="albumArtwork" src="">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0" ></span>
                    </span>
                    <span class="artistName">
                        <span role="link" tabindex="0" ></span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">

            <div class="content playerControls">

                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
                        <img src="assets/images/icons/dark/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous" onclick="prevSong()">
                        <img src="assets/images/icons/dark/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play" onclick="playSong()">
                        <img src="assets/images/icons/dark/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/dark/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next" onclick="nextSong()">
                        <img src="assets/images/icons/dark/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
                        <img src="assets/images/icons/dark/repeat.png" alt="Repeat">
                    </button>
                </div> 

                <div class="playbackBar">

                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">

                        <div class="progressBarBackground">
                            <div class="progress"></div>
                        </div>

                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>

            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume" onclick="setMute()">
                    <img src="assets/images/icons/dark/volume.png" alt="Volume">
                </button>

                <div class="progressBar">

                    <div class="progressBarBackground">
                        <div class="progress"></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>