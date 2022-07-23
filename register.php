<?php
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    $account = new Account();

    include("includes/handlers/registedHandler.php");
    include("includes/handlers/loginHandler.php");

?>

<html lang="pt">
<head><title>Welcome to Sporkify</title>
</head>
<body>
    <div id="inputContainer">
        <form id="loginForm" action="register.php" method="POST">
            <h2>Login to your account</h2>
            <p>
                <label for="loginUsername">Username</label>
                <input id="loginUsername" name="loginUsername" type="text" placeholder="Bart Simpson" required>
            </p>
            <p>
                <label for="loginPassword">Password</label>
                <input id="loginPassword" name="loginPassword" type="password" required>
            </p>
            <button type="submit" name="loginButton">Login</button>
        </form>




        <form id="registerForm" action="register.php" method="POST">
            <h2>Create your free account</h2>
            <p>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Bart Simpson" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                
                <label for="firstName">First name</label>
                <input id="firstName" name="firstName" type="text" placeholder="Bart" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                
                <label for="lastName">Last name</label>
                <input id="lastName" name="lastName" type="text" placeholder="Simpson" required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$emailDoNotMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" placeholder="bart@gmail.com" required>
            </p>

            <p>
                <label for="email2">Confirm e-mail</label>
                <input id="email2" name="email2" type="email" placeholder="bart@gmail.com" required>
            </p>
            
            <p>
                <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$passwordNotAlphanumberic); ?>
                <?php echo $account->getError(Constants::$passwordCharacters); ?>
                
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Your password" required>
            </p>

            <p>
                <label for="password2">Confirm password</label>
                <input id="password2" name="password2" type="password" placeholder="Your password" required>
            </p>
            <button type="submit" name="registerButton">Sign Up</button>
        </form>
    </div>
</body>
</html>