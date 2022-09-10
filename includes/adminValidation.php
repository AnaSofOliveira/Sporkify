<?php 

    if($userLoggedIn->getRole() != "admin"){
        echo "<script>openPage('noPermissions.php');</script>";
    }
?>