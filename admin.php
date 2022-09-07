<?php 
    include("includes/includedFiles.php"); 
    require ("includes/__private/spotifyData.php");
?>

<div class="buttonGroup">

    <div class="buttonItems">
        <button class="button" onclick="openPage('addSong.php')">Add Song</button>
        <button class="button" onclick="openPage('removeSongDetails.php')">Remove Song</button>
        <button class="button" onclick="openPage('manageUserDetails.php')">Manage User</button>
        <button class="button green" onclick="userLogInRequest()">Spotify Ideas</button>
    </div>

</div>



<script>
    const userLogInRequest = () => {
        let logInUri = 'https://accounts.spotify.com/authorize' +
            '?client_id=<?php echo $__app_client_id; ?>' +
            '&response_type=code' +
            '&redirect_uri=<?php echo $__redirect_uri; ?>' +
            '&scope=app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state' +
            '&show_dialog=false';

        //console.debug(logInUri);

        window.open(logInUri, '_self');
    }
</script>

