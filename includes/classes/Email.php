<?php

    include ("includes/__private/HtmlMimeMail.php");
    include ("includes/__private/lib-mail-v2.php");

    class Email{

        private $con;
        private $id, $accountName, $smtpServer, $port, $useSSL, $timeout, $loginName, $password, $fromEmail, $fromName;

        public function __construct($con){
            $this->con = $con;

            $query = mysqli_query($this->con , "SELECT * FROM `emailAccounts`");
            $result = mysqli_fetch_array( $query);

            $this->id = $result[ 'id' ];
            $this->accountName = $result['accountName'];
            $this->smtpServer = $result[ 'smtpServer' ];
            $this->port = intval( $result[ 'port' ] );
            $this->useSSL = boolval( $result[ 'useSSL' ] );
            $this->timeout = intval( $result[ 'timeout' ] );
            $this->loginName = $result[ 'loginName' ];
            $this->password = $result[ 'password' ];
            $this->fromEmail = $result[ 'email' ];
            $this->fromName = $result[ 'displayName' ];

        }

        public function sendEmail($user){

            // To info - username, e-mail
            $ToName = $user->getUsername(); 
            $ToEmail = $user->getEmail();
            $id = $user->getId();

            // Code 
            $query = mysqli_query($this->con, "SELECT challenge FROM challenges WHERE idUser='$id'");
            $row = mysqli_fetch_array($query); 
            $code = $row['challenge'];

            $validationURL = "http://localhost/examples-smi/Sporkify/validate?";

            // General info
            $Subject = "Sporkify - Validação do registo";
            $Message = "Para validar o teu registo no Sporkify acede ao seguinte link: ".$validationURL."code=".$code.".";
            $Debug = FALSE;
                    
            $email = sendAuthEmail($this->smtpServer, $this->useSSL, $this->port, $this->timeout, $this->loginName,
                $this->password, $this->fromEmail, $this->fromName, $ToName . " <" . $ToEmail . ">", NULL,
                NULL, $Subject, $Message, $Debug, NULL);
                
            if($email == true) {
                return true; 
            }
            return false;
        }

    }

?>