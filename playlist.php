<?php 

    include("includes/includedFiles.php"); 

    if(isset($_GET['id'])){
        $playlistId = $_GET['id'];
    }else{
        header("Location: index.php");
    }

    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getOwner());

?>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png">
        </div>
        </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberSongs(); ?> Songs</p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId;?>')">Delete Playlist</button>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">

        <?php 
            $songIdArray = $playlist->getSongIds(); 
            $rowNumber = 1;

            foreach($songIdArray as $songId){
                
                $playlistSong = new Song($con, $songId); 
                $songArtist = $playlistSong->getArtist();

                echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/dark/play-white.png' onclick='setTrack(\"".$playlistSong->getId()."\", tempPlaylist, true)'>
                        <span class='trackNumber'>$rowNumber</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>".$playlistSong->getTitle()."</span>
                        <span class='artirsName'>".$songArtist->getName()."</span>
                    </div>

                    <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/dark/more.png' onclick='showOptionsMenu(this)'> 
                    </div>

                    <div class='trackDuration>
                        <span class='duration'>".$playlistSong->getDuration()."</span>
                    </div>
                </li>";

                $rowNumber++;
            }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
</nav>
