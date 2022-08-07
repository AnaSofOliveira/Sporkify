<?php
    include("includes/includedFiles.php"); 
?>

<div class="userDetails">

    <div class="container borderBottom">
        <h2>E-mail</h2>
        <input type="text" class="email" name="email" placeholder="E-mail address" value="<?php echo $userLoggedIn->getEmail();?>">
        <span class="message"></span>
        <button class="button" onclick="">Save</button>
    </div>

    <div class="container">
        <h2>Password</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
        <input type="password" class="newPassword1" name="newPassword1" placeholder="New password">
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="">Save</button>
    </div>
</div>