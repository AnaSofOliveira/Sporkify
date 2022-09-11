<?php

if(!isset($con)){

    $config_filename = "/examples/Sporkify/assets/xml/config.xml"; 
    $configFile = file_exists($config_filename);

    /* echo getcwd();
    if(!$configFile){
        echo "| ".getcwd();
        header( 'Location: '.getcwd().'setup.php');
    }else{ */

        // read database info from file
        $aux = simplexml_load_file($config_filename) or die( header("Location: setup.php")); 
        $configDatabase = $aux->DataBase[0];

        ob_start();
        session_start();

        $timezone = date_default_timezone_set("Europe/London");

        /* $con = mysqli_connect("localhost", "root", "", "sporkify");  */
        $con = mysqli_connect($configDatabase->host, $configDatabase->username, $configDatabase->password, $configDatabase->db); 

        if(mysqli_connect_errno()){
            echo "Failed to connect: " . mysqli_connect_errno();
        }
    }
    /* }   */     
?>