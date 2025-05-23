<?php

    class Constants{

        // Register Error Messages
        public static $passwordsDoNotMatch = "Your passwords don't match."; 
        public static $passwordNotAlphanumberic = "Your password can only contain numbers and letters.";
        public static $passwordCharacters = "Your username must be between 5 and 30 characters."; 
        public static $emailInvalid = "E-mail is invalid."; 
        public static $emailDoNotMatch = "Your e-mails don't match."; 
        public static $lastNameCharacters = "Your last name must be between 2 and 25 characters."; 
        public static $firstNameCharacters = "Your first name must be between 2 and 25 characters."; 
        public static $usernameCharacters = "Your username must be between 5 and 25 characters."; 
        public static $usernameTaken = "This username already exists.";
        public static $emailTaken = "This e-mail already exists.";

        // Login Error Messages
        public static $loginFailed = "Your username or password was incorrect";
        public static $accountNotValid = "Your account is not active. Please validate your e-mail.";

        // Erro no registo da conta
        public static $registerError = "Error registering the account. Please try again later.";

        // Conta criada
        public static $accountCreated = "Your account has been created. Please validate your e-mail.";
    
    }

?>