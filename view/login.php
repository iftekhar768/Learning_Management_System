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
</head>
<body>
    <form action="../controller/authController.php" method="POST">
        <label for="userId">User Id: </label>
        <input type="text" name="userId" id="userId"><br><br>
        <label for="pass">Password: </label>
        <input type="text" name="pass" id="pass"><br><br>
        <input type="submit" name="login" value="login">
    </form>
</body>
</html>