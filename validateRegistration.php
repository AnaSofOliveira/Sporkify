<?php

    include("includes/config.php"); 
    include("includes/adminValidation.php");

    if(isset($_GET['userId'])){
        $userId = $_GET['userId'];

        $query = mysqli_query($con, "UPDATE `users` SET `state`=TRUE WHERE `id`='$userId'");
        $query = mysqli_query($con, "DELETE FROM `challenges` WHERE `idUser`='$userId'");

        $query = mysqli_query($con, "SELECT `username`,`state` FROM `users` WHERE `id`='$userId'");

        $result = mysqli_fetch_array($query); 

    }else if(isset($_GET['code'])){
        
        $code = $_GET['code'];

        $query = mysqli_query($con, "SELECT `idUser` FROM `challenges` WHERE `challenge`='$code'"); 
        $result = mysqli_fetch_array($query); 

        

        if(isset($result)){

            $userId = $result['idUser']; 

            $query = mysqli_query($con, "UPDATE `users` SET `state`=TRUE WHERE `id`='$userId'");
            $query = mysqli_query($con, "DELETE FROM `challenges` WHERE `idUser`='$userId'");

            $query = mysqli_query($con, "SELECT `username`,`state` FROM `users` WHERE `id`='$userId'");

            $result = mysqli_fetch_array($query); 

            echo "<html lang='pt'>
                    <head>
                        <title>Welcome to Sporkify</title>
                        <link id='style' rel='stylesheet' type='text/css' href='assets/css/lightTheme.css'>
                        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
                        <script src='assets/js/script.js'></script>
                    </head>
                    <body>
                    </body>
                    <script>openPage('".$_SERVER['REQUEST_URI']."');</script>
                </html>";
        }else{
            echo "Invalid code passed into validateRegistration.php";
        }
        
    }else{
        echo "UserId or Role was not passed into validateRegistration.php";
    }

?>