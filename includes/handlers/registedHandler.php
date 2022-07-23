<?php
    function sanitizeFormUsername($inputText){ 
        // Remove todos os elementos html que podem ter sido inseridos no campo
        $inputText = strip_tags($inputText); 
        // Remove os espaços em branco por uma string vazia
        $inputText = str_replace(" ", "", $inputText);
        return $inputText; 
    }

    function sanitizeFormString($inputText){ 
        $inputText = strip_tags($inputText); 
        $inputText = str_replace(" ", "", $inputText);
        // Coloca a primeira letra em uppercase, no entanto primeiro
        // é necessário colocar todo o input com letras minusculas
        $inputText = ucfirst(strtolower($inputText)); 
        return $inputText; 
    }

    function sanitizeFormPassword($inputText){ 
        $inputText = strip_tags($inputText); 
        return $inputText; 
    }

    
    if(isset($_POST['registerButton'])){
        // Register button was pressed
        $username = sanitizeFormUsername($_POST['username']);
        $firstName = sanitizeFormString($_POST['firstName']);
        $lastName = sanitizeFormString($_POST['lastName']);
        $email = sanitizeFormString($_POST['email']);
        $email2 = sanitizeFormString($_POST['email2']);
        $password = sanitizeFormString($_POST['password']);
        $password2 = sanitizeFormString($_POST['password2']);

        $wasSuccessfull = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

        if($wasSuccessfull){
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }

    }

?>