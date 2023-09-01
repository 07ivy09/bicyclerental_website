<?php
@include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form is submitted
    $error = array();
    $msg = array();

    $daily = $_POST['daily'];

    $bicyclesNumber = $_POST['bicyclesNumber'] ?? '';
    $payment = $_POST['payment'] ?? '';

    // Validate daily
    if ($daily !== 'Daily' && $daily !== 'Hourly') {
        $error[] = 'Invalid daily option selected';
    }

    // Validate bicyclesNumber
    if (!is_numeric($bicyclesNumber) || $bicyclesNumber < 1) {
        $error[] = 'Invalid number of bicycles';
    }

    // Validate payment
    if ($payment !== 'UPI' && $payment !== 'Debit Card') {
        $error[] = 'Invalid payment option selected';
    }

    // Apply Discount
    $discount = 0;
    if ($bicyclesNumber > 1) {
        $discount = $bicyclesNumber - 1;
        if ($daily == 'Daily') {
            $discount *= 5;
        } else {
            $discount *= 1;
        }
    }

    // If there are no errors, process the form data
    if (empty($error)) {
        // Process the form data or perform database actions here
        // For this example, we will just display a success message.
        $totalCost = ($daily === 'Daily') ? $bicyclesNumber * 50 : $bicyclesNumber * 5;
        $totalCost -= $discount;

        $user_id = $_SESSION['user_id'];

        // Insert data into the rented_bicycles table
        $insertQuery = "INSERT INTO rented_bicycles (user_id, daily_or_hourly, bicycles_count, payment_method, total_cost)
                        VALUES ($user_id, '$daily', $bicyclesNumber, '$payment', $totalCost)";
        
        // Execute the query
        mysqli_query($conn, $insertQuery); 

        $msg[] = "Bicycles rented successfully!";

        if ($discount != 0){
            $msg[] = "You got a discount of Rs . ".$discount;
        }

        ?>
        <script>
            // Wait for 5 seconds (adjust the time as needed)
            setTimeout(function () {
                // Redirect to another page using JavaScript
                window.location.href = "user_page.php";
            }, 4000); // 5000 milliseconds = 5 seconds
        </script>
        <?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post">
        <a href="user_page.php"><span style="float: right">Go Back</span></a>
        <h3>
            Bicycles Rental
        </h3>
        
        <?php
        if (isset($error)) {
            foreach ($error as $error_msg) {
                echo '<span class="error-msg">' . $error_msg . '</span>';
            }
        }
        if (isset($msg)) {
            foreach ($msg as $m) {
                echo '<span class="success-msg">' . $m . '</span>';
            }
        }
        ?>
        <select name="daily" id="dailySelect">
            <option value="Daily">Daily</option>
            <option value="Hourly">Hourly</option>
        </select>

        <input type="number" id="bicyclesNumberInput" name="bicyclesNumber" required placeholder="No of days you want to rent">
        
        <select name="payment">
            <option value="UPI">UPI</option>
            <option value="Debit Card">Debit Card</option>
        </select>
        <input type="submit" name="submit" id="rentButton" value="Rent Now" class="form-btn">
    </form>
</div>
<script>

document.addEventListener('DOMContentLoaded', function() {

    // Get references to the select and input elements
    const dailySelect = document.getElementById('dailySelect');
    const bicyclesNumberInput = document.getElementById('bicyclesNumberInput');
    
    // Add event listener to the select element
    dailySelect.addEventListener('change', function() {

        const selectedValue = dailySelect.value;
    
        
        if (selectedValue === 'Daily') {
            bicyclesNumberInput.placeholder = 'No of days you want to rent';
        } else if (selectedValue === 'Hourly') {
            bicyclesNumberInput.placeholder = 'No of hours you want to rent';
        }
    });

    const rentButton = document.getElementById("rentButton"); // Assuming the button has the id "rentButton"

    rentButton.addEventListener("click", function(event) {
        if (dailySelect.value === "Daily" && bicyclesNumberInput.value > 2) {
            alert("Maximum of 2 days for daily rental.");
            event.preventDefault(); // Prevent form submission
        } else if (dailySelect.value === "Hourly" && bicyclesNumberInput.value > 5) {
            alert("Maximum of 5 hours required for hourly rental.");
            event.preventDefault(); // Prevent form submission
        }
    });
});


</script>
</body>
</html>
