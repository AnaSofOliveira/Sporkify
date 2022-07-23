<?php

    class Account{

        private $errorArray; 

        public function __construct(){
            $this->errorArray = array();
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
                return true;
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

        private function validateUsername($un){

            echo "Username to validade: ".$un."| size: ".strlen($un);
            // tamanho do username precisa de estar entre 5 e 25
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters); 
                return;
            }

            // TODO: Check if username exists
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

            // TODO: Check that username hasn't already been used
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