<?php
    require_once("userController.php");
    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) 
    {
        session_start();

        $user = [
            "user_id" => $_POST["userId"],
            "name"    => $_POST["username"],
            "role"    => $_POST["roleSelect"],
            "email"   => $_POST["email"],
            "pass"    => $_POST["pass"]
        ];

        require_once("userController.php");
        $result = registeringUser($user);

        if ($result) {
            echo "User registered successfully!";
        } else {
            echo "Error in registration.";
        }
    }



?>