<?php

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
    $email     = $_POST['Email'];
    $phone     = $_POST['Phone'];
    $dob       = $_POST['dob'];
    $role      = $_POST['Role'];
    $password  = $_POST['Password'];
    $cpassword = $_POST['CPassword'];

    if ($password !== $cpassword) {
        echo "Passwords do not match!";
    } else {
        // Hash password for security
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_table (user_name, email, phone, dob, role, user_pass) 
                VALUES ('$user_name', '$email', '$phone', '$dob', '$role', '$hashed_pass')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Registration</h1>
    <form action="registration.php" method="POST">
        <label for="UserName">User Name :</label>
        <input type="text" id="UserName" name="UserName" required><br><br>

        <label for="Email">Email : </label>
        <input type="email" id="Email" name="Email" required><br><br>

        <label for="Phone">Phone : </label>
        <input type="text" id="Phone" name="Phone" required><br><br>

        <label for="dob">Date of Birth :</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="Role">Role: </label>
        <input type="radio" name="Role" value="Teacher" required>Teacher
        <input type="radio" name="Role" value="Student" required>Student
        <br><br>

        <label for="Password">Password :</label>
        <input type="password" id="Password" name="Password" required><br><br>

        <label for="CPassword">Confirm Password :</label>
        <input type="password" id="CPassword" name="CPassword" required><br><br>

        <input type="submit" value="Register">
        <button><a href="login.php">Login</a></button>
    </form>
</body>
</html>