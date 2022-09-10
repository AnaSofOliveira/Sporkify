<?php
    include("includes/classes/Constants.php");

    include("includes/handlers/setupHandler.php");

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>

<html lang="pt">
<head>
    <title>Configurations</title>
    <link rel="stylesheet" type="text/css" href="assets/css/setup.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>   
    <div id="background">
        <div id="setupContainer">
            <div id="inputContainer">
                <form id="setupForm" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h2>Setup your Database</h2>
                    <p>
                        <label for="databaseName">Database Name</label>
                        <input id="databaseName" name="databaseName" type="text" value="<?php getInputValue('databaseName') ?>" required>
                    </p>
                    <p>
                        <label for="databaseUsername">Database Username</label>
                        <input id="databaseUsername" name="databaseUsername" type="text" required>
                    </p>
                    <p>
                        <label for="databasePassword">Database Password</label>
                        <input id="databasePassword" name="databasePassword" type="password" required>
                    </p>
                    <p>
                        <label for="server">Server</label>
                        <input id="server" name="server" type="text" required>
                    </p>
                    <p>
                        <label for="port">Port</label>
                        <input id="port" name="port" type="number" required>
                    </p>
                    <button type="submit" name="setupButton">Submit</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>