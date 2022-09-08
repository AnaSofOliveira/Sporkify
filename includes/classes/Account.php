<?php

    class Account{

        private $con;
        private $errorArray; 

        public function __construct($con){
            $this->errorArray = array();
            $this->con = $con;
        }

        public function login($un, $pw){
            $pw = md5($pw); 

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

            $state = mysqli_fetch_array($query)["state"];
            $num_results = mysqli_num_rows($query);

            echo "State: ".$state." | num_results: ".$num_results;

            if($num_results == 1 && $state){
                return true;
            }elseif($num_results == 1 && !$state){
                echo "accountNotValid";
                array_push($this->errorArray, Constants::$accountNotValid);
                return false;
            }else{
                echo "loginFailed";
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstname($fn);
            $this->validateLastname($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

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

        public function setError($error){
            array_push($this->errorArray, $error);
        }

        private function insertUserDetais($un, $fn, $ln, $em, $pw){
            $encrypetedPw = md5($pw); 
            $profilePic = "assets/images/profile-pics/profile.png";
            $date = date("Y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic, role, state) VALUES ('$un', '$fn', '$ln', '$em', '$encrypetedPw', '$date', '$profilePic', 'user', '0')");

            return $result;
            
        }

        function generate_challenge($user){

            $username = $user->getUsername(); 
            $email = $user->getEmail();

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $row = mysqli_fetch_array($query);

            $userId = $row['id'];
            $md5_code = md5($username.$email);

            $result = mysqli_query($this->con, "INSERT INTO challenges(idUser, challenge) VALUES ('$userId','$md5_code')");
        
            $query = mysqli_query($this->con, "SELECT * FROM challenges WHERE idUser='$userId'");
            $row = mysqli_fetch_array($query);

            return $row['challenge'];
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