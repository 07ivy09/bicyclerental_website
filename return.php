<?php

include('config.php');

if($_GET['id']){
    $rent_id = $_GET['id'];

    $select = "DELETE FROM rented_bicycles WHERE rent_id = '$rent_id'";

    $result = mysqli_query($conn, $select);

    header('Location: view_rents.php');
 
}

?>