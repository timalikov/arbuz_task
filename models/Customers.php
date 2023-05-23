<?php 
  class Customers {
    // DB stuff
    private $conn;
    private $table = 'customers';

    // Post Properties
    public $id;
    public $name;
    public $email;
    public $address;
    public $phone;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT c.id, c.name, c.email, c.address, c.phone
                                FROM ' . $this->table . ' c
                                ORDER BY
                                  c.id DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT c.id, c.name, c.email, c.address, c.phone
                                FROM ' . $this->table . ' c
                                    WHERE
                                      c.id = ?
                                      LIMIT 1 OFFSET 0';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->name = $row['name'];
          $this->email = $row['email'];
          $this->address = $row['address'];
          $this->phone = $row['phone'];
    }

    // Create Post
    public function create() {
          // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          //   // Get the data from the POST request body
          //   $name = $_POST['name'];
          //   $email = $_POST['email'];
          //   $address = $_POST['address'];
          //   $phone = $_POST['phone'];
        
          //   // Insert the data into the table
          //   $query = "INSERT INTO cutomers (name, email, address, phone) VALUES (?, ?, ?, ?)";
          //   $stmt = $pdo->prepare($query);
          //   $stmt->execute([$name, $email, $address, $phone]);
    
      // Create query
          $query = 'INSERT INTO ' . $this->table . ' (name, email, address, phone) VALUES (:name, :email, :address, :phone)';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->address = htmlspecialchars(strip_tags($this->address));
          $this->phone = htmlspecialchars(strip_tags($this->phone));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':address', $this->address);
          $stmt->bindParam(':phone', $this->phone);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET name = :name, email = :email, address = :address, phone = :phone
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->address = htmlspecialchars(strip_tags($this->address));
          $this->phone = htmlspecialchars(strip_tags($this->phone));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':address', $this->address);
          $stmt->bindParam(':phone', $this->phone);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }