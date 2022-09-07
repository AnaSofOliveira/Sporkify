<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo" >
            <img src="assets/images/logo.png">
        </span>

        <div class="group">
            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('search.php')"  class="navItemLink">
                    Search 
                    <img src="assets/images/icons/dark/search.png" class="icon" alt="search">
            </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>
            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your music</span>
            </div>
            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>
        </div>

        <?php if($userLoggedIn->getRole() == "admin") {?>
            <div class="group bottom">
                <div class="navItem">
                    <span role="link" tabindex="0" onclick="openPage('admin.php')" class="navItemLink">Admin</span>
                </div>
            </div>
        <?php }?>
    </nav>
</div>