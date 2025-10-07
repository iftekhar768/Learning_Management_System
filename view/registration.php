<?php
    require_once("../model/database.php");
    require_once("../controller/userController.php");
    require_once("../model/userModel.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../assets/css/regstyle.css">
</head>
<body>
    <div class="container">
    <form action="../controller/authController.php" method="POST">
        <div class="listContainer">
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
            <input type="submit" name="submit" value="register" id="submitBtn"><br>
            <div class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>     
    </form>
    </div>
</body>
</html>