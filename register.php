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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>   

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form id="loginForm" action="register.php" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                        <label for="loginUsername">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="Bart Simpson" value="<?php getInputValue('loginUsername') ?>" required>
                        </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" required>
                    </p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <button type="submit" name="loginButton">Login</button>

                </form>

            </div>
            <div id="inputContainer">

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
                    
                    <div class="g-recaptcha" data-sitekey="6Lep6N4hAAAAACTsOFu0Pv6j-6j5RUQ9ttgL8rEz"></div>

                    <button type="submit" name="registerButton">Sign Up</button>
                    
                </form>
            </div>

        </div>
    </div>
</body>
</html>