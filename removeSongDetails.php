<?php

    include("includes/includedFiles.php"); 

?>



<div class="songListContainer">
    <h2>Songs</h2>
    <ul class="songList">

        <?php 
            $songIdArray = array(); 

            $query = mysqli_query($con, "SELECT * FROM songs");

            $rowNumber = 1;
            while($row = mysqli_fetch_array($query)){
                $song = new Song($con, $row['id']); 

                $id = $song->getId();
                array_push($songIdArray, $id); 

                $title = $song->getTitle();
                $artist = $song->getArtist();
        
            
                echo "<li class='songListRow'>
                    <div class='songCount'>
                        <img class='play' src='assets/images/icons/dark/play-white.png' onclick='setTrack(\"".$id."\", tempPlaylist, true)'>
                        <span class='trackNumber'>$rowNumber</span>
                    </div>

                    <div class='songInfo'>
                        <span class='songName'>".$title."</span>
                        <span class='artistName'>".$artist->getName()."</span>
                    </div>

                    <div class='songOptions'>
                        <input type='hidden' class='songId' value='" . $id . "'>
                        <img class='optionsButton' src='assets/images/icons/dark/trash.png' onclick='removeSongFromDB(this)'> 
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


