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

  // Get ID
  $customers->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $customers->read_single();

  // Create array
  $customers_array = array(
    'id' => $customers->id,
    'name' => $customers->name,
    'email' => $customers->email,
    'address' => $customers->address,
    'phone' => $customers->phone,
  );

  // Make JSON
  print_r(json_encode($customers_array));