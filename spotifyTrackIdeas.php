<?php
    include("includes/includedFiles.php");
    require ("includes/classes/CurlServer.php");
?>

<div class="trackListContainer borderBottom">
    <h2>Songs</h2>
    <ul class="trackList">

        <?php 

            $__cURL = new CurlServer();

            $req_url = "https://api.spotify.com/v1/me/top/tracks?time_range=medium_term&limit=10&offset=5";
            
            $response = $__cURL->get_request($req_url, $_SESSION['spotify_token']->access_token); 
            
            foreach($response->items as $item){

                echo("<p>Name: ".$item->name."</p>");
                echo("<p>External URL (Spotify): ".$item->external_urls->spotify."</p>");
                
                $artists = $item->artists; 
                echo ("<p> Artists: </p>");
                foreach($artists as $artist){
                    echo ("<p> - Name: ".$artist->name."</p>");
                }

                echo ("<p> Images: </p>");
                $images = $item->album->images; 
                foreach ($images as $image){
                    echo ("<p>- URL: ".$image->url." (height = ".$image->height."; width = ".$image->width.")</p>");
                }

                //Divide by 1,0000
                $timestampSeconds = $item->duration_ms / 1000;
                //Format it into a human-readable datetime.
                $formatted = date("i:s", $timestampSeconds);

                echo ("<p> Duração: ".$formatted."</p>");

                echo ("</br>");

                //print_r($item);
            }


        ?>

    </ul>
</div>