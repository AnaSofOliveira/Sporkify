<?php 

    include("includes/includedFiles.php"); 

    if(isset($_GET['id'])){
        $albumId = $_GET['id'];
    }else{
        header("Location: index.php");
    }

    $album = new Album($con, $albumId);
    $artist = $album->getArtist();

?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>">
        </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artist->getId(); ?>')">By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberSongs(); ?> Songs</p>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">

        <?php 
            $songIdArray = $album->getSongIds(); 
            $rowNumber = 1;

            foreach($songIdArray as $songId){
                
                $albumSong = new Song($con, $songId); 
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/dark/play-white.png' onclick='setTrack(\"".$albumSong->getId()."\", tempPlaylist, true)'>
                        <span class='trackNumber'>$rowNumber</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>".$albumSong->getTitle()."</span>
                        <span class='artirsName'>".$albumArtist->getName()."</span>
                    </div>

                    <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/dark/more.png' onclick='showOptionsMenu(this)'> 
                    </div>

                    <div class='trackDuration>
                        <span class='duration'>".$albumSong->getDuration()."</span>
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
</nav>
