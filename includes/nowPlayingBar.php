<?php 

    $song_query = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    
    $resutlArray = array();
    while($row = mysqli_fetch_array($song_query)){
        array_push($resutlArray, $row['id']);
    }

    $jsonArray = json_encode($resutlArray);
?>

<script>

    $(document).ready(function(){
        curentPlaylist = <?php echo $jsonArray ?>;
        audioElement = new Audio();
        setTrack(curentPlaylist[0], curentPlaylist, false);
    });

    function setTrack(trackId, newPlaylist, play){
        audioElement.setTrack("assets/music/bensound-anewbeginning.mp3");
        
        if(play){
            audioElement.play();
        }        
    }

    function playSong(){
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong(){
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
                    <img class="albumArtwork" src="https://media-exp1.licdn.com/dms/image/C4D0BAQFnn6OfqAHbcQ/company-logo_200_200/0/1647267997850?e=2147483647&v=beta&t=uuIPYBjcPCU9f8oGk38cSMvJiu29ilz4X66IFmnJHgo">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span>Happy Birthday</span>
                    </span>
                    <span class="artistName">
                        <span>Ana Oliveira</span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">

            <div class="content playerControls">

                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat">
                        <img src="assets/images/icons/repeat.png" alt="Repeat">
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
                <button class="controlButton volume" title="Volume">
                    <img src="assets/images/icons/volume.png" alt="Volume">
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