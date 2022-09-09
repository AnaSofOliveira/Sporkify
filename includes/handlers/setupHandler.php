<?php
    if(isset($_POST['setupButton'])){

        $database = $_POST['databaseName']; 
        $username = $_POST['databaseUsername']; 
        $password = $_POST['databasePassword']; 
        $server = $_POST['server']; 
        $port = $_POST['port']; 

        $data = "<?xml version='1.0' encoding='utf-8'>
        <Config>
          <DataBase>
              <host>".$server."</host>
              <port>".$port."</port>
              <db>".$database."</db>
              <username>".$username."</username>
              <password>".$password."</password>
          </DataBase>
        </Config>";

        



        // Login button was pressed
        $username = $_POST['loginUsername']; 
        $password = $_POST['loginPassword']; 

        $result = $account -> login($username, $password);
        if($result){
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        } 
    }
?>