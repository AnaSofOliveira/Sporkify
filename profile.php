<?php 
    include("includes/includedFiles.php"); 
?>

<div class="entityInfo">

    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
            <img src='<?php echo $userLoggedIn->getProfilePic();?>'>
        </div>
    </div>

    <div class="buttonItems">
        <button class="button" onclick="openPage('updateDetails.php')">User Details</button>
        <button class="button" id="mode" onclick="changeThemeMode()">Light Mode</button>
        <button class="button" onclick="logout()">Logout</button>
    </div>
</div>
