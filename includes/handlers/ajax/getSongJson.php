<?php 

    include("../../config.php"); 

    if(isset($_POST['songId'])){

        $songId = $_POST['songId']; 
        echo "SongId: ".$songId;
         
        echo "Con: ".$con;
        $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

        $resultArray = mysqli_fetch_array($query); 

        print_r("$resultArray - AJAX - GetSongJson.php: ".$resultArray);

        echo json_encode($resultArray);
    }

?>