<?php

    include("includes/includedFiles.php"); 
    include("includes/adminValidation.php");

?>


<div class="userListContainer">
    <h2>Inactive Users</h2>
    <ul class="userList">

        <?php 

            $query = mysqli_query($con, "SELECT * FROM users");

            while($row = mysqli_fetch_array($query)){
                $user = new User($con, $row['username']); 

                $id = $user->getId();
                $username = $user->getUsername();
                
                $email = $user->getEmail();
                $urlPicture = $user->getProfilePic();
                $state = $user->getState();
        
                if(!$state){
                    echo "<li class='userListRow'>
                                    <div class='profilePic'>
                                        <img src='".$urlPicture."'>
                                    </div>

                                    <div class='userInfo'>
                                        <span class='username'>".$username."</span>
                                        <span class='email'>".$email."</span>
                                    </div>
                                    <div class='stateInfo'>
                                        <span class='state'>".$state."</span>
                                    </div>

                                    <div class='userOptions'>
                                        <input type='hidden' class='userId' value='" . $id . "'>
                                        <img class='validate' src='assets/images/icons/dark/validate.png' onclick='validateRegistration(this)'>
                                    </div>
                                </li>";                 
                }
            }
        ?>
    </ul>
</div>
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
                $state = $user->getState();

                if($state){
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
                        $result = $result."<img class='trash' src='assets/images/icons/dark/trash.png' onclick='removeUserFromDB(this)'> 
                                            <img class='lock_close' src='assets/images/icons/dark/lock_close.png' onclick='changePermission(this, \"".$role."\")'>";
                    }else{
                        $result = $result."<img class='lock_open' src='assets/images/icons/dark/lock_open.png' onclick='changePermission(this, \"".$role."\")'>";
                    }

                    $result = $result."</div></li>" ;

                    echo $result;
                }
            }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>


