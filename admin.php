<?php

include('config.php');

session_start();

if(isset($_POST['submit'])){

   $admin = mysqli_real_escape_string($conn, $_POST['admin']);
   $pass = $_POST['password'];

   $select = "SELECT * FROM admin_form WHERE `admin` = '$admin' AND `password` = '$pass'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      $_SESSION['admin'] = $row['admin'];
    //   $_SESSION['user_id'] = $row['id'];
      header('Location:adminpage.php');
     
   }else{
      $error[] = 'incorrect text or password!';
   }



}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/common.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="#" method="post">
      <h3>Admin Page</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text"  id="admin" name="admin" maxlength="20" required placeholder="Admin">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Admin Login" class="form-btn">
      <p>Only for admin use!  <a href="user_page.php"> Register Now </a></p>
   </form>

</div>
<script>
   const nameInput = document.getElementById("name");
   nameInput.addEventListener("input", restrictInputToCharacters);

   function restrictInputToCharacters() {
      const name = nameInput.value;
      // Remove any non-alphabetic characters
      const sanitizedInput = name.replace(/[^A-Za-z ]/g, '');

      // Update the input field with the sanitized value
      nameInput.value = sanitizedInput;

      // Enable the submit button only if the input is not empty
      const submitButton = document.querySelector('input[type="submit"]');
      submitButton.disabled = sanitizedInput.length === 0;
   }
</script>
</body>
</html>