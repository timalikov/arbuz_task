<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Customers.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $customers = new Customers($db);

  // Blog post query
  $result = $customers->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any customers
  if($num > 0) {
    // Post array
    $customers_array = array();
    // $customers_array['data'] = array(); 

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $customers_item = array(
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'phone' => $phone
      );

      // Push to "data"
      array_push($customers_array, $customers_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($customers_array);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
