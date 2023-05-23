<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=UTF-8');

include_once '../../config/Database.php';
include_once '../../models/Subscriptions.php';


// Instantiate subscriptions object
session_start();
$customer_id = $_SESSION['customer_id'];

  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Create Subscription</title>
  </head>
  <body>
    <h1>Create Subscription</h1>
    <form method="post" action="create.php">
        <label for="customerid">Customer ID:</label>
        <input type="text" name="customerid" id="customerid" required disabled value="<?php echo isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : ''; ?>"><br>

        <!-- Select delivery day -->
        <label for="delivery_day">Delivery Day:</label>
        <select name="delivery_day" id="delivery_day" required>
        <option value="">Select a day</option>
        <?php
        $weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        foreach ($weekdays as $weekday) {
            echo "<option value=\"$weekday\">$weekday</option>";
        }
        ?>
        </select><br>

        <!-- Select delivery period of day -->
        <label for="delivery_period">Preferred part of the day for delivery:</label>
        <select name="delivery_period" id="delivery_period" required>
        <option value="">Select a part of the day</option>
        <?php
        $periods = array('Morning', 'Afternoon', 'Evening');
        foreach ($periods as $period) {
            echo "<option value=\"$period\">$period</option>";
        }
        ?>
        </select><br>

        <label for="delivery_frequency">Delivery Period:</label>
        <select name="delivery_frequency" id="delivery_frequency" required>
        <option value="">Select a period</option>
        <?php
        $periods = array('Daily', 'Weekly', 'Fortnightly', 'Monthly');
        foreach ($periods as $period) {
            echo "<option value=\"$period\">$period</option>";
        }
        ?>
        </select><br>


        <label for="subscription_duration">Subscription Duration (weeks):</label>
        <input type="number" id="subscription_duration" name="subscription_duration" min="5" step="5"/><br><br>

        <label for="address">Address</label>
        <input type="text" name="address" id="address"><br>

        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone"><br>


        <input type="submit" value="Create Subscription">
    </form>
  </body>
  </html>

