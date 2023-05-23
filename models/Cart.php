<?php 
    class Cart {
    // DB stuff
        private $conn;
        private $table = 'cart';

        // Post Properties
        public $id;
        public $customer_id;
        public $product_id;
        public $quantity;

        // Constructor with DB
        public function __construct($db) {
        $this->conn = $db;
        }

         // Add to Cart method
        public function addToCart() {
            // Logic to add an item to the cart
            // You can retrieve the customer_id, product_id, and quantity from the request or function parameters

            // Sample code to execute an insert query
            $query = 'INSERT INTO ' . $this->table . 
                ' (customer_id, product_id, quantity) VALUES (:customer_id, :product_id, :quantity)';

            $stmt = $this->conn->prepare($query);

                   // Clean data
            $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->quantity = htmlspecialchars(strip_tags($this->quantity));

            $stmt->bindParam(':customer_id', $this->customer_id);
            $stmt->bindParam(':product_id', $this->product_id);
            $stmt->bindParam(':quantity', $this->quantity);

            if ($stmt->execute()) {
                return true; // Item added successfully
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>