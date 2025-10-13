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
    <script src="../assets/js/reg.js" defer></script>
</head>
<body>
    <div class="container">
    <form action="../controller/authController.php" method="POST" onsubmit="return validationForm()">
        <div class="listContainer">
            <label for="userId">User ID:</label>
            <input type="text" name="userId" id="userId">
            <span id="idErr"></span>
            <br><br>
            <label for="username">Name: </label>
            <input type="text" name="username" id="username">
            <span id="nameErr"></span>
            <br><br>
            <label for="roleSelect">Role: </label>
            <input type="radio" name="roleSelect" value="teacher" id="roleSelect">Teacher
            <input type="radio" name="roleSelect" value="student" id="roleSelect">Student
            <span id="roleErr"></span>
            <br><br>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email">
            <span id="emailErr"></span>
            <br><br>
            <label for="pass">Password: </label>
            <input type="text" name="pass" id="pass">
            <span id="passErr"></span>
            <br><br>
            <input type="submit" name="submit" value="register" id="submitBtn"><br>
            <div class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>     
    </form>
    </div>
</body>
</html>