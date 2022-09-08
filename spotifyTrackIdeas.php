<?php
    include("includes/includedFiles.php");
    require ("includes/classes/CurlServer.php");
?>

<div class="spotifyTrackListContainer">
    <h2 class="pageHeadingBig">Songs</h2>
    <ul class="spotifyTrackList">

            <?php 

                $__cURL = new CurlServer();

                $req_url = "https://api.spotify.com/v1/me/top/tracks?time_range=medium_term&limit=10&offset=5";
                
                $response = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token); 
                
                $trackNumber = 1;

                foreach($response->items as $item){

                    $trackName = $item->name;
                    $external_spotify_url = $item->external_urls->spotify;

                    /* echo("<p>Name: ".$trackName."</p>");
                    echo("<p>External URL (Spotify): ".$external_spotify_url."</p>"); */
                    
                    $artistsName = "";

                    $artists = $item->artists; 
                    $index = 1;
                    foreach($artists as $artist){
                        $artistName = $artist->name;
                        if($index == 1){
                            $artistsName = $artistName;
                        }else{
                            $artistsName = $artistsName." & ".$artistName;
                        }
                        $index++;
                    }
                    /* echo ("<p> Artists: ".$artistsName."</p>");

                    echo ("<p> Images: </p>"); */
                    $images = $item->album->images; 
                    foreach ($images as $image){
                        if($image->height == 300){
                            $image_url = $image->url;
                        }
/*                         echo ("<p>- URL: ".$image->url." (height = ".$image->height."; width = ".$image->width.")</p>");
 */                    }

                    //Divide by 1,0000
                    $timestampSeconds = $item->duration_ms / 1000;
                    //Format it into a human-readable datetime.
                    $formatted = date("i:s", $timestampSeconds);

                    /* echo ("<p> Duração: ".$formatted."</p>");

                    echo ("</br>"); */

                    //print_r($item);

                    echo "<li class='spotifyTrackListRow'>
                            <div class='spotifyTrackCount'>
                                <img class='album_img' src='".$image_url."' >
                                <span class='trackNumber'>".$trackNumber."</span>
                            </div>

                            <div class='spotifyTrackInfo'>
                                <span class='spotifyTrackName'>".$trackName."</span>
                                <span class='spotifyArtirsName'>".$artistsName."</span>
                            </div>

                            <div class='spotifyTrackOptions' onclick='window.open(\"".$external_spotify_url."\")'>
                                    <img class='optionsButton' src='assets/images/icons/spotify_logo.png'> 
                            </div>

                            <div class='spotifyTrackDuration'>
                                <span class='duration'>".$formatted."</span>
                            </div>
                        </li>";
                    
                        $trackNumber++; 

                }


            ?>

        </ul>
    </div>
</div>