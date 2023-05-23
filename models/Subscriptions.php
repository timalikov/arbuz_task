<?php 
  class Subscriptions {
    // DB stuff
    private $conn;
    private $table = 'subscriptions';

    // Post Properties
    public $id;
    public $customer_id;
    public $delivery_day;
    public $delivery_period;
    public $subscription_duration;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT s.id, s.customer_id, s.delivery_day, s.delivery_period, s.subscription_duration
                                FROM ' . $this->table . ' s
                                ORDER BY
                                  s.id DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . ' s
                                    WHERE
                                      s.id = ?
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
          $this->customer_id = $row['customer_id'];
          $this->delivery_day = $row['delivery_day'];
          $this->delivery_period = $row['delivery_period'];
          $this->subscription_duration = $row['subscription_duration'];
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
          $query = 'INSERT INTO ' . $this->table . ' (customer_id, delivery_day, delivery_period, subscription_duration) VALUES (:name, :email, :address, :phone)';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
          $this->delivery_day = htmlspecialchars(strip_tags($this->delivery_day));
          $this->delivery_period = htmlspecialchars(strip_tags($this->delivery_period));
          $this->subscription_duration = htmlspecialchars(strip_tags($this->subscription_duration));

          // Bind data
          $stmt->bindParam(':customer_id', $this->customer_id);
          $stmt->bindParam(':delivery_day', $this->delivery_day);
          $stmt->bindParam(':delivery_period', $this->delivery_period);
          $stmt->bindParam(':subscription_duration', $this->subscription_duration);

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
                                SET customer_id = :customer_id, delivery_day = :delivery_day, delivery_period = :delivery_period, subscription_duration = :subscription_duration
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
          $this->delivery_day = htmlspecialchars(strip_tags($this->delivery_day));
          $this->delivery_period = htmlspecialchars(strip_tags($this->delivery_period));
          $this->subscription_duration = htmlspecialchars(strip_tags($this->subscription_duration));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':customer_id', $this->customer_id);
          $stmt->bindParam(':delivery_day', $this->delivery_day);
          $stmt->bindParam(':delivery_period', $this->delivery_period);
          $stmt->bindParam(':subscription_duration', $this->subscription_duration);

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