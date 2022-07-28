<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    $account = new Account($con);

    include("includes/handlers/registedHandler.php");
    include("includes/handlers/loginHandler.php");

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>

<html lang="pt">
<head>
    <title>Welcome to Sporkify</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>

<?php
    if(isset($_POST['registerButton'])){
        echo '<script>
            $(document).ready(function(){
                $("#loginForm").hide();
                $("#registerForm").show();
            });    
        </script>';
    }else {
        echo '<script>
        $(document).ready(function(){
            $("#loginForm").show();
            $("#registerForm").hide();
        });    
    </script>';
    }
?>
    

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form id="loginForm" action="register.php" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                        <label for="loginUsername">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="Bart Simpson" required>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" required>
                    </p>
                    <button type="submit" name="loginButton">Login</button>

                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account yet? Signup here.</span>
                    </div>
                </form>




                <form id="registerForm" action="register.php" method="POST">
                    <h2>Create your free account</h2>
                    <p>
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" placeholder="Bart Simpson" value="<?php getInputValue('username') ?>" required>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                    </p>

                    <p>
                        
                        <label for="firstName">First name</label>
                        <input id="firstName" name="firstName" type="text" placeholder="Bart" value="<?php getInputValue('firstName') ?>" required>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                    </p>

                    <p>
                        
                        <label for="lastName">Last name</label>
                        <input id="lastName" name="lastName" type="text" placeholder="Simpson" value="<?php getInputValue('lastName') ?>" required>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                    </p>

                    <p>
                        <label for="email">E-mail</label>
                        <input id="email" name="email" type="email" placeholder="bart@gmail.com" value="<?php getInputValue('email') ?>" required>
                        <?php echo $account->getError(Constants::$emailDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                    </p>

                    <p>
                        <label for="email2">Confirm e-mail</label>
                        <input id="email2" name="email2" type="email" placeholder="bart@gmail.com" value="<?php getInputValue('email2') ?>" required>
                    </p>
                    
                    <p>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Your password" required>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordNotAlphanumberic); ?>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                    </p>

                    <p>
                        <label for="password2">Confirm password</label>
                        <input id="password2" name="password2" type="password" placeholder="Your password" required>
                    </p>
                    <button type="submit" name="registerButton">Sign Up</button>
                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Login here.</span>
                    </div>
                </form>
            </div>

            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>

                <ul>
                    <li>Discover music you'll fall in love with</li>
                    <li>Create your own playlists</li>
                    <li>Follow artists to keep up to date</li>
                </ul>

            </div>
        </div>
    </div>
</body>
</html>