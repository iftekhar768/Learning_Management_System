<?php
    require_once("../model/database.php");
    require_once("../controller/authController.php");
    require_once("../controller/userController.php");
    require_once("../model/userModel.php");
    
   
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action="../controller/authController.php" method="POST">
        <label for="userId">User ID:</label>
        <input type="text" name="userId" id="userId"><br><br>
        <label for="username">Name: </label>
        <input type="text" name="username" id="username"><br><br>
        <label for="roleSelect">Role: </label>
        <input type="radio" name="roleSelect" value="teacher" id="roleSelect">Teacher
        <input type="radio" name="roleSelect" value="student" id="roleSelect">Student
        <br><br>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email"><br><br>
        <label for="pass">Password: </label>
        <input type="text" name="pass" id="pass"><br><br>
        <input type="submit" name="submit" value="register"><br>
         
    </form>
</body>
</html>