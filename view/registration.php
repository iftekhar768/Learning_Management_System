<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Registration</h1>
    <form action="">
        <label for="UserName">User Name :</label>
        <input type="text" id="UserName"><br><br>
        <label for="Email">Email : </label>
        <input type="email" id="Email"><br><br>
        <label for="Phone">Phone : </label>
        <input type="number" id="Phone"> <br><br>
        <label for="bod">Date of Birth :</label>
        <input type="date" id="bod"> <br><br>
        <label for="Role">Role: </label>
        <input type="radio" name="" id="Teacher">Teacher
        <input type="radio" id="Student">Student
        <br><br>
        <label for="Password">Password :</label>
        <input type="password" id="Password"> <br><br>
        <label for="CPassword">Confirm Password :</label>
        <input type="password" id="CPassword"> <br><br>
        <input type="submit" value="submit">
        <button> <a href="login.php">Login</a></button>

    </form>
</body>
</html>