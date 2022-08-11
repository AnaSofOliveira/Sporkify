<?php

    include("includes/includedFiles.php"); 

?>



<div class="userListContainer">
    <h2>Active Users</h2>
    <ul class="userList">

        <?php 

            $query = mysqli_query($con, "SELECT * FROM users");

            while($row = mysqli_fetch_array($query)){
                $user = new User($con, $row['username']); 

                $id = $user->getId();
                $username = $user->getUsername();
                
                $email = $user->getEmail();
                $urlPicture = $user->getProfilePic();
                $role = $user->getRole();
        
            
                $result = "<li class='userListRow'>
                                <div class='profilePic'>
                                    <img src='".$urlPicture."'>
                                </div>

                                <div class='userInfo'>
                                    <span class='username'>".$username."</span>
                                    <span class='email'>".$email."</span>
                                </div>
                                <div class='roleInfo'>
                                    <span class='role'>".$role."</span>
                                </div>

                                <div class='userOptions'>
                                    <input type='hidden' class='userId' value='" . $id . "'>"; 

                if($role != "admin"){
                    $result = $result."<img class='optionsButton' src='assets/images/icons/trash.png' onclick='removeUserFromDB(this)'> 
                                        <img class='optionsButton' src='assets/images/icons/lock_close.png' onclick='changePermission(this, \"".$role."\")'>";
                }else{
                    $result = $result."<img class='optionsButton' src='assets/images/icons/lock_open.png' onclick='changePermission(this, \"".$role."\")'>";
                }

                $result = $result."</div></li>" ;

                echo $result;

            }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>


