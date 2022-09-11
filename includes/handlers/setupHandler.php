<?php
    if(isset($_POST['setupButton'])){

        $database = $_POST['databaseName']; 
        $username = $_POST['databaseUsername']; 
        $password = $_POST['databasePassword']; 
        $server = $_POST['server']; 
        $port = $_POST['port']; 

        $data = '<?xml version="1.0" encoding="UTF-8"?>
        <Config>
            <DataBase>
                <host>'.$server.'</host>
                <port>'.$port.'</port>
                <db>'.$database.'</db>
                <username>'.$username.'</username>
                <password>'.$password.'</password>
            </DataBase>
        </Config>';

        file_put_contents(dirname(__DIR__, 2)."/assets/xml/config.xml", $data);

        header("Location: index.php");
    }
?>