<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['phone']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";

   $result = mysqli_query($conn, $select);


   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password) VALUES('$name','$email','$pass')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }


};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>
   <link rel="stylesheet" href="css/common.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">
<a href="index.php" class="admin-btn"><span style="position: absolute; top: 0px; left: 0px;">Home Page</span></a>

   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text"  id="name" name="name" maxlength="20" required placeholder="Enter your name">
      <input type="number" name="phone" id="phone" maxlength="10" required placeholder="Enter your phone number">
      <input type="password" name="password" maxlength="10" required placeholder="Enter your password">
      <input type="password" name="cpassword" maxlength="10" required placeholder="Confirm your password">
      <input type="submit" name="submit" value="Register now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
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

   const numberInput = document.getElementById("phone");
   numberInput.addEventListener("input", restrictInputToTenDigits);

   function restrictInputToTenDigits() {
      const number = numberInput.value;
      const restrictedNumber = number.slice(0, 10); // Take only the first 10 characters

      numberInput.value = restrictedNumber; // Update the input value with restricted number
   }

</script>
</body>
</html>