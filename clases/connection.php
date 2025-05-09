<?php

class Connection {
        private $host;
        private $userName;
        private $password;
        private $db;
        protected $conn;
        private $configFile = "conf.json"; //where database credentials are stored//
    
        public function __construct() { //establish database connection//
            $this -> connect();
        }
    
        public function __destruct() { //nullifies conn when object is destroyed//
            if ($this -> conn) {
                $this -> conn = null;
            }
        }
    
        public function connect() { //read database from conf.json//
            if (!file_exists($this -> configFile)) {
                die("Unable to open file!");
            }
    
            $configData = file_get_contents($this -> configFile); //turns json into string//
            $config = json_decode($configData, true); //string to array//
    
            $this -> host = $config['host'];
            $this -> userName = $config['userName'];
            $this -> password = $config['password'];
            $this -> db = $config['db'];
            $this -> conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->userName, $this->password);
    
            $this->conn->exec("SET NAMES 'utf8'");
        }
        
        public function getConn() { //returns pdo connection so it can be used elsewhere in code//
            return $this -> conn;
        }
}
?>