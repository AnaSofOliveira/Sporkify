<?php 

    include("../../config.php"); 

    if(isset($_POST['userId']) && isset($_POST['role'])){
        $userId = $_POST['userId'];
        $role =  $_POST['role'];

        $newRole = ($role == "admin")? "user" : "admin"; 
        
        $query = mysqli_query($con, "UPDATE users SET role = '$newRole' WHERE id='$userId'");

    }else{
        echo "UserId or Role was not passed into updateRole.php";
    }

?>