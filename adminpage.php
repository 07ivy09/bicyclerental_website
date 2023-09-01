<?php
@include 'config.php';
session_start();

// if(!isset($_SESSION['admin'])){
//     header('location:index.php');
// }


// $user_id = $_SESSION['admin'];

// Fetch the user's orders from the database
$selectQuery = "SELECT * FROM rented_bicycles";
$result = mysqli_query($conn, $selectQuery);
?>
<?php
if (!$result || mysqli_num_rows($result) === 0) {
    echo " ";
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>User Orders</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <a href="index.php" class="admin-btn"><span style="position: absolute; top: 0px; left: 0px;">Home Page</span></a>
        <div class="form-container">
            <form action="" method="post" style="width: auto;">
                <h2>User Orders</h2>
                <br>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Daily or Hourly</th>
                    <th>No of hours/days</th>
                    <th>Payment Method</th>
                    <th>Total Cost</th>
                    <th>Rent Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['rent_id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['daily_or_hourly']; ?></td>
                        <td><?php echo $row['bicycles_count']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo 'Rs. ' . $row['total_cost']; ?></td>
                        <td><?php echo $row['rent_date']; ?></td>
                        
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
            </form>
            </div>
    </body>
    </html>
    <?php
}
?>



<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post">
        <a href="register_form.php"><h3>No orders found</h3></a>
        <a href="index.php"><span style="float: right">Go to homepage </span></a>

       
        <?php
        if (isset($error)) {
            foreach ($error as $error_msg) {
                echo '<span class="error-msg">' . $error_msg . '</span>';
            }
        }
        ?>
</div>
</body>
</html>
