<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Customers.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $customers = new Customers($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $customers->id = $data->id;

  $customers->name = $data->name;
  $customers->email = $data->email;
  $customers->address = $data->address;
  $customers->phone = $data->phone;

  // Update post
  if($customers->update()) {
    echo json_encode(
      array('message' => 'Customer Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Customer Not Updated')
    );
  }
