<?php

    class User{

        private $con;
        private $username;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getId(){
            $query = mysqli_query($this->con, "SELECT id FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query); 
            return $row['id'];
        }

        public function getEmail(){
            $query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query); 
            return $row['email'];
        }

        public function getFirstAndLastName(){
            $query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query); 
            return $row['name'];
        }

        public function getProfilePic(){
            $query = mysqli_query($this->con, "SELECT profilePic FROM users WHERE username='$this->username'"); 
            $row = mysqli_fetch_array($query); 

            return $row['profilePic'];
        }

        public function getRole(){
            $query = mysqli_query($this->con, "SELECT role FROM users WHERE username='$this->username'"); 
            $row = mysqli_fetch_array($query); 

            return $row['role'];
        }

        public function getState(){
            $query = mysqli_query($this->con, "SELECT state FROM users WHERE username='$this->username'"); 
            $row = mysqli_fetch_array($query); 

            return $row['state'];
        }
    }

?>