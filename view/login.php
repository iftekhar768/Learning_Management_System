<?php
    
    require_once("../controller/userController.php");
    session_start();
   


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
     <link rel="stylesheet" href="../assets/css/login.css">
      <script src="../assets/js/log.js" defer></script>
</head>
<body>
    <div class="container">
    <h1>Log In</h1>
    <form action="../controller/authController.php" method="POST" onsubmit="return validationForm()">
      <label for="userId">User ID:</label>
      <input type="text" name="userId" id="userId" required>
       <span id="idErr"></span>
      <label for="pass">Password:</label>
      <input type="password" name="pass" id="pass" required>
       <span id="passErr"></span>
      <input type="submit" name="login" value="LOGIN">

      <div class="register-link">
        Don't have an account? <a href="registration.php">Register</a>
      </div>
    </form>
  </div>
</body>
</html>