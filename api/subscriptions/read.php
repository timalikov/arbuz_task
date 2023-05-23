<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Subscriptions.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $subscriptions = new Subscriptions($db);

  // Blog post query
  $result = $subscriptions->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any customers
  if($num > 0) {
    // Post array
    $subscriptions_array = array();
    // $customers_array['data'] = array(); 

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $subscriptions_item = array(
        'id' => $id,
        'customer_id' => $customer_id,
        'delivery_day' => $delivery_day,
        'delivery_period' => $delivery_period,
        'subscription_duration' => $subscription_duration
      );

      // Push to "data"
      array_push($subscriptions_array, $subscriptions_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($subscriptions_array);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
