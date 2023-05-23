<?php

  include_once '../../config/Database.php';
  include_once '../../models/Customers.php';
  include_once '../../models/Cart.php';

  session_start();    //Example customer
  $customer_id = $_SESSION['customer_id'];
  
  // Database connection
  $database = new Database();
  $db = $database->connect();

  $query = "SELECT product_id, quantity FROM cart WHERE customer_id = :customer_id";
  $stmt = $db->prepare($query);

  $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);

  // Execute query
  $stmt->execute();

  $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $weightByQuantities = [];

  foreach ($cartItems as $cartItem) {
    $productId = $cartItem['product_id'];
    $quantity = $cartItem['quantity'];
  
    // Prepare the query to select the weight from the products table
    $productQuery = "SELECT weight FROM products WHERE id = :product_id";
    $productStmt = $db->prepare($productQuery);
    $productStmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
    $productStmt->execute();
  
    // Fetch the weight
    $weight = $productStmt->fetchColumn();
  
    // Calculate the weighted quantity
    $weightedQuantity = $weight * $quantity;
  
    // Store the weighted quantity in the array
    $weightedQuantities[] = $weightedQuantity;
  }

  $totalWeight = 0;

  if (!empty($weightedQuantities)) {
    // Calculate the total weight
    $totalWeight = array_sum($weightedQuantities);
  
    // Use the total weight as needed
    echo "Total weight: " . $totalWeight . "<br>";
  } else {
    echo "No weighted quantities found. <br>";
  }

// Определение тарифов для расчета стоимости доставки в зависимости от веса товара: 
// До 1 кг: 300 Тенге
// От 1 кг до 5 кг: 500 Тенге
// От 5 кг до 10 кг: 1000 Тенге
// Свыше 10 кг: 2000 Тенге
  function calculateShippingCost($weight) {
    if ($weight <= 1) {
      return 300;
    } elseif ($weight <= 5) {
      return 500;
    } elseif ($weight <= 10) {
      return 1000;
    } else {
      return 2000;
    }
  }

  // Вес товара
  $shippingCost = calculateShippingCost($totalWeight);
  echo "Стоимость доставки: " . $shippingCost . " Тенге";
?>