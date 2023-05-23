<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Customers.php';
  include_once '../../models/Cart.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  $cart = new Cart($db);

  // Check if the request method is POST and perform the add to cart action
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the necessary data from the request (e.g., customer_id, product_id, quantity)
  
  $data = json_decode(file_get_contents("php://input"));

    // Set the values in the Cart object
  $cart->customer_id = $data->customer_id;
  $cart->product_id = $data->product_id;
  $cart->quantity = $data->quantity;

  //Check whether the product exists in the storage
  $query = "SELECT quantity FROM inventory WHERE product_id = :product_id";

  // Prepare the statement
  $stmt = $db->prepare($query);

  // Bind the parameter
  $stmt->bindParam(':product_id', $cart->product_id);

  // Execute the query
  $stmt->execute();

  // Fetch the result
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $quantity = $result['quantity'];
    if($cart->quantity >= $quantity){
        // Call the addToCart method to add the item to the cart
        if ($cart->addToCart()) {
          // Item added successfully
        echo json_encode(
            array('message' => 'Item added successfully')
            );
        } else {
            // Failed to add item
        echo json_encode(
            array('message' => 'Failed to add item')
            );
        }
    }else{
      echo "Unfortunately we don't have this product in stock.";
      echo "The quantity of $cart->product_id in the inventory is: $quantity";

    }
  } else {
    echo "Product not found in the inventory.";
  }
  

 
  }
?>