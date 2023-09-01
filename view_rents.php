<?php
@include 'config.php';
session_start();

// if(!isset($_SESSION['user_name'])){
//     header('location:login_form.php');
// }

$user_id = $_SESSION['user_id'];

// Fetch the user's orders from the database
$selectQuery = "SELECT * FROM rented_bicycles WHERE user_id = $user_id";
$result = mysqli_query($conn, $selectQuery);
?>
<?php
if (!$result || mysqli_num_rows($result) === 0) {
    echo "No orders found for this user.";
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>User Orders</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="form-container">
            <form action="" method="post" style="width: auto;">
                <h2>User Orders</h2>
                <br>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Daily or Hourly</th>
                    <th>No of hours/days</th>
                    <th>Payment Method</th>
                    <th>Total Cost</th>
                    <th>Rent Date</th>
                    <th>Return</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['rent_id']; ?></td>
                        <td><?php echo $row['daily_or_hourly']; ?></td>
                        <td><?php echo $row['bicycles_count']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo 'Rs. ' . $row['total_cost']; ?></td>
                        <td><?php echo $row['rent_date']; ?></td>
                        <td><a href="Return.php?id=<?php echo $row['rent_id']?>">Return</a></td>
                        
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </form>
    <a href="user_page.php"><span style="position: absolute; top: 0px; left: 0px; font-size: 20px; padding: 5px; color: white; text-decoration: underline;">Go Back to User Page</span></a>
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
        <a href="user_page.php"><h3>View User page</h3></a>
        <a href="user_page.php"><span style="float: right">Go Back</span></a>

       
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
