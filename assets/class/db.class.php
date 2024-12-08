<?php
    class db{
        private $host = 'localhost';
        private $username = 'root';
        private $database = 'resume_builder';
        private $password = '';
        private $port = 3307;
        private $dbs = null;

        function __construct(){
           $this->dbs= new mysqli($this->host,$this->username,$this->password,$this->database,$this->port);
        }
        public function connect(){
            return $this->dbs;
        }
    }

    $database = new db();
    $database= $database->connect();



?>