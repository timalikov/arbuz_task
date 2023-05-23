<?php
  include_once '../../config/Database.php';

        
  session_start();
  $customer_idd = $_SESSION['customer_id'];


  $customer_id = $customer_idd;


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_day'])) {
    // POST request from HTML form
    $delivery_day = $_POST['delivery_day'];
    $delivery_period = $_POST['delivery_period'];
    $delivery_frequency = $_POST['delivery_frequency'];
    $subscription_duration = $_POST['subscription_duration'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone'];
  } else {
    // Raw JSON data sent
    $data = json_decode(file_get_contents("php://input"));
    $delivery_day = $data->delivery_day;
    $delivery_period = $data->delivery_period;
    $delivery_frequency = $data->delivery_frequency;
    $subscription_duration = $data->subscription_duration;
    $address = $data->address;
    $phone_number = $data->phone_number;
  }
  

// Database connection
  $database = new Database();
  $db = $database->connect();

  $query = "insert into subscriptions(customer_id, delivery_day, delivery_period, delivery_frequency, subscription_duration, address, phone_number) values(:customer_id, :delivery_day, :delivery_period, :delivery_frequency, :subscription_duration, :address, :phone_number)";
  $stmt = $db->prepare($query);
  // $stmt->bindParam($customer_id, $delivery_day, $delivery_period, $subscription_duration);
  $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
  $stmt->bindValue(':delivery_day', $delivery_day, PDO::PARAM_STR);
  $stmt->bindValue(':delivery_period', $delivery_period, PDO::PARAM_STR);
  $stmt->bindValue(':delivery_frequency', $delivery_frequency, PDO::PARAM_STR);
  $stmt->bindValue(':subscription_duration', $subscription_duration, PDO::PARAM_INT);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
  $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);

  $execval = $stmt->execute();
  echo $execval;
  echo "Subsctiption created successfully...";
		// $stmt->close();
		// $conn->close();
	// }
?>