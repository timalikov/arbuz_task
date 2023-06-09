<?php 
  class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'arbuz';
    private $username = 'postgres';
    private $password = '1234';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
    }
    

      return $this->conn;
    }
  }