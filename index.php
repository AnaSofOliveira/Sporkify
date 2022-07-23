<?php
    include("includes/config.php");
    
    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = $_SESSION['userLoggedIn']; 
    }else{
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to Sporkify</title>
</head>
<body>
    Hello!
</body>
</html>