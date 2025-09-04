<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_table";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['UserName'];
    $password  = $_POST['Password'];

    // Fetch user from database
    $sql = "SELECT * FROM user_table WHERE user_name = '$user_name' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['user_pass'])) {
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['role']      = $row['role'];

            // Redirect based on role
            if ($row['role'] == "Teacher") {
                header("Location: Teacher/dashboard.php");
                exit;
            } elseif ($row['role'] == "Student") {
                header("Location: Student/dashboard.php");
                exit;
            } else {
                echo "Unknown role!";
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found!";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    <h1>Log In</h1>
    <form action="login.php" method="POST">
        <label for="UserName">UserName: </label>
        <input type="text" id="UserName" name="UserName" required><br><br>

        <label for="Password">Password: </label>
        <input type="password" id="Password" name="Password" required><br><br>

        <input type="submit" value="Login">
        <button><a href="registration.php">Registration</a></button>
        <br><br>

        <a href="#">Can't Access your Account?</a>
    </form>
</body>
</html>
