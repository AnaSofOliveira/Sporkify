<?php
    include("includes/config.php");
    
    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = $_SESSION['userLoggedIn']; 
    }else{
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Welcome to Sporkify</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

    <div id="mainContainer">
        <div id="topContainer">
            <div id="navBarContainer">
                <nav class="navBar">
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo.png">
                    </a>

                    <div class="group">
                        <div class="navItem">
                            <a href="search.php" class="navItemLink">
                                Search 
                                <img src="assets/images/icons/search.png" class="icon" alt="search">
                            </a>
                        </div>
                    </div>

                    <div class="group">
                        <div class="navItem">
                            <a href="browse.php" class="navItemLink">Browse</a>
                        </div>
                        <div class="navItem">
                            <a href="yourMusic.php" class="navItemLink">Your music</a>
                        </div>
                        <div class="navItem">
                            <a href="profile.php" class="navItemLink">User Profile</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

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

                            <button class="controlButton play" title="Play">
                                <img src="assets/images/icons/play.png" alt="Play">
                            </button>

                            <button class="controlButton pause" title="Pause" style="display: none;">
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
    </div>
</body>
</html>