<?php

    class Account{

        private $con;
        private $errorArray; 

        public function __construct($con){
            $this->errorArray = array();
            $this->con = $con;
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstname($fn);
            $this->validateLastname($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            print_r($this->errorArray);
            // Se não existirem erros após as validações acima
            if(empty($this->errorArray)){
                // TODO: Insert into DB
                return $this->insertUserDetais($un, $fn, $ln, $em, $pw);
            }else{
                return false;
            }
        }

        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetais($un, $fn, $ln, $em, $pw){
            $encrypetedPw = md5($pw); 
            $profilePic = "assets/images/profile-pics/profile.png";
            $date = date("Y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) VALUES ('$un', '$fn', '$ln', '$em', '$encrypetedPw', '$date', '$profilePic')");

            return $result;
            
        }

        private function validateUsername($un){

            // tamanho do username precisa de estar entre 5 e 25
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters); 
                return;
            }

            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'"); 
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
            }
        }
    
        private function validateFirstname($fn){
            if(strlen($fn) > 25 || strlen($fn) < 2){
                array_push($this->errorArray, Constants::$firstNameCharacters); 
                return;
            }
        }
    
        private function validateLastname($ln){
            if(strlen($ln) > 25 || strlen($ln) < 2){
                array_push($this->errorArray, Constants::$lastNameCharacters); 
                return;
            }
        }
    
        private function validateEmails($em, $em2){
            if($em != $em2){
                array_push($this->errorArray, Constants::$emailDoNotMatch); 
                return;
            }

            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid); 
                return;
            }

            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'"); 
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
            }
        }
    
        private function validatePasswords($pw, $pw2){
            if($pw != $pw2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch); 
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $pw)){
                array_push($this->errorArray, Constants::$passwordNotAlphanumberic); 
                return;
            }

            if(strlen($pw) > 30 || strlen(($pw) < 5)){
                array_push($this->errorArray, Constants::$passwordCharacters); 
                return;
            }
        }

    }

?>