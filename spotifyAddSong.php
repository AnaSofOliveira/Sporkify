<?php
    include("includes/includedFiles.php");
    require ("includes/classes/CurlServer.php");
    
    if(isset($_GET['term'])){
        $term = urldecode($_GET['term']);
    }else{
        $term = "";
    }
    
?>

<div class="searchContainer">

    <h4>Search for an artist, album or song</h4>
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing...">
</div>

<script>

    $(".searchInput").focus();

    $(function(){

        $(".searchInput").keyup(function(){
            clearTimeout(timer);

            timer = setTimeout(function(){
                var val = $(".searchInput").val();
                openPage("spotifyAddSong.php?term=" + val);
                
            }, 2000); // TODO verificar melhor tempo
        })
    })

    $(document).ready(function(){
		$(".searchInput").focus();
		var search = $(".searchInput").val();
		$(".searchInput").val('');
		$(".searchInput").val(search);
	})

</script>

<?php
    if($term == ""){
        exit();
    }
?>

<div class="trackListContainer borderBottom">
    <h2>Songs</h2>
    <ul class="trackList">

        <?php 

            echo $_SESSION['spotify_token']->access_token;

            $__cURL = new CurlServer();

            $encodedTerm = urlencode($term);

            $req_url = "https://api.spotify.com/v1/search?q=name:".$encodedTerm."%20track:".$encodedTerm."&type=track&limit=15&market=PT";
            
            $response = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token); 
            
            //print_r($response);
            //echo "<h1>Albuns: </h1>";
            //echo "<pre>";
            //print_r($response->albums); 
            //echo "</pre>";

            
            /* echo "<h1>Tracks: </h1>"; */
            /* echo "<pre>"; */
            //print_r($response->tracks->items);

            foreach($response->tracks->items as $track){
                /* echo "<p>Track: ".$track->id; */

                $image_url = $track->album->images[1]->url;

                /* echo "\nImageURL: ";
                print_r($image_url); */

                $trackId = $track->id;
                $req_url = "https://api.spotify.com/v1/tracks/".$trackId;
                $response = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token);

                //echo "\nResponse: ";
                //print_r($response);


                /* echo "\nName: ";
                print_r($response->name);
                echo "\npreview_url: ";
                print_r($response->preview_url);
                echo "\ntype: ";
                print_r($response->type);
                echo "\nduration_ms: ";
                print_r($response->duration_ms); */


                $artists = $track->artists; 

                foreach($artists as $artist){
                    $artistName = $artist->name; 
                    
                    /* echo "\nArtist Name: ";
                    print_r($artistName); */
                }

                //Divide by 1,0000
                $timestampSeconds = $response->duration_ms / 1000;

                //Format it into a human-readable datetime.
                $formatted = date("i:s", $timestampSeconds);
                /* echo "\nduration: ";
                print_r($formatted);
                
                
                //print_r($response);

                echo "</p>"; */




                echo "<li class='trackListRow'>
                <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' >
                        <span class='trackNumber'>1</span>
                    </div>
                <div class='trackInfo'>
                    <span class='trackName'>".$response->name."</span>
                    <span class='artirsName'>".$artistName."</span>
                </div>

                <div class='trackOptions'>
                    
                    <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'> 
                </div>

                <div class='trackDuration>
                    <span class='duration'>".$formatted."</span>
                </div>
            </li>";


            }

            //echo "</pre>"; 




            $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

            if(mysqli_num_rows($songsQuery) == 0){
                echo "<span class='noResults'>No songs found matching ".$term."</span>";
            }

            $songIdArray = array();
            $rowNumber = 1;

            while($row = mysqli_fetch_array($songsQuery)){
                
                if($rowNumber > 15){
                    break;
                }

                array_push($songIdArray, $row['id']);

                $albumSong = new Song($con, $row['id']); 
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"".$albumSong->getId()."\", tempPlaylist, true)'>
                        <span class='trackNumber'>$rowNumber</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>".$albumSong->getTitle()."</span>
                        <span class='artirsName'>".$albumArtist->getName()."</span>
                    </div>

                    <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'> 
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
