<?php

    $config_filename = "/assets/xml/config.xml"; 
    $teste = file_exists($config_filename);

    if(!file_exists(getcwd().$config_filename)){
        header( 'Location: setup.php');
    }else{

        if(isset($GLOBALS['database']) && isset($GLOBALS['username']) && isset($GLOBALS['password']) && isset($GLOBALS['server']) && isset($GLOBALS['port'])){
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                include("includes/config.php");
                include("includes/classes/User.php");
                include("includes/classes/Artist.php");
                include("includes/classes/Album.php");
                include("includes/classes/Song.php");
                include("includes/classes/Playlist.php");
        
                echo "<script>
                        applyTheme();
                    </script>";
        
                if(isset($_GET['userLoggedIn'])){
                    $userLoggedIn = new User($con, $_GET['userLoggedIn']);
                }else{
                    echo "username variable was not passed into the page. Check the openPage JS function";
                    exit();
                }
            }
            else{
                include("includes/header.php");
                include("includes/footer.php");  
        
                $url = $_SERVER['REQUEST_URI'];
                echo "<script>
                        openPage('$url');
                    </script>";
                exit();
            }
        }else{

            // read database info from file
            $aux = simplexml_load_file(getcwd().$config_filename) or die( "Can't read data base configuration file.");; 
            $configDataBase = $aux->DataBase[0];

            print_r($configDataBase);

        }

    }

        

?>