<?php
include_once '../../config/Database.php';
include_once '../../models/Customers.php';
include_once '../../models/Cart.php';

$database = new Database();
$db = $database->connect();



$customer_id = 1; // Example user ID.

// Save the customer ID
session_start();
// Set the customer_id
$_SESSION['customer_id'] = $customer_id;




$connection = $db;

$cart = new Cart($db);

// Retrieve cart information from the database.
$query = "SELECT c.product_id, p.name, c.quantity
          FROM cart c
          INNER JOIN products p ON c.product_id = p.id
          WHERE c.customer_id = :customer_id";

$statement = $connection->prepare($query);
$statement->bindParam(':customer_id', $customer_id);
$statement->execute();
$cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Current Cart</title>
</head>
<body>
    <h1>Current Cart</h1>

    <?php if (count($cartItems) > 0): ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['product_id']; ?></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button>BUY</button> <!-- example button -->

        <form action="http://127.0.0.1/php_rest/api/subscriptions/create_subscription.php">
            <input type="hidden" name="cart" value="<?php echo htmlentities(json_encode($cartItems)); ?>">
            <input type="submit" value="Subscribe for weekly delivery">
        </form>

    <?php else: ?>
        <p>No items in the cart.</p>
    <?php endif; ?>



</body>
</html>
