<?php
    include("../../config.php");

    if(isset($_POST['songId'])){
 
        $songId = $_POST['songId']; 

        $querySong = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'"); 

        $song = mysqli_fetch_array($querySong);
        
        $artistId = $song['artist'];
        $albumId = $song['album'];
        $genreId = $song['genre'];


        // Remove a música das playlists
        $playlistQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE songId='$songId'"); 
        

        // Verificar se há mais musicas com o mesmo artista
        $artistQuery = mysqli_query($con, "SELECT COUNT('id') as songsWithArtists FROM songs WHERE artist='$artistId';"); 

        $result = mysqli_fetch_array($artistQuery);
        if($result['songsWithArtists'] <= 1){
            mysqli_query($con, "DELETE FROM artists WHERE id='$artistId'");
        }

        // Verificar se há mais musicas no mesmo album
        $albumQuery = mysqli_query($con, "SELECT COUNT('id') as songsWithAlbum FROM songs WHERE album='$albumId';"); 
        
        $result = mysqli_fetch_array($albumQuery);
        if($result['songsWithAlbum'] <= 1){
            mysqli_query($con, "DELETE FROM albums WHERE id='$albumId'");
        }

        // Verificar se há mais músicas com o mesmo genero 
        $genreQuery = mysqli_query($con, "SELECT COUNT('id') as songsWithGenre FROM songs WHERE genre='$genreId';"); 

        $result = mysqli_fetch_array($genreQuery);
        if($result['songsWithGenre'] <= 1){
            mysqli_query($con, "DELETE FROM genres WHERE id='$genreId'");
        }

        mysqli_query($con, "DELETE FROM songs WHERE id='$songId'");
        
    }
    else{
        echo "SongId was not passed into deleteSong.php";
    }
?>