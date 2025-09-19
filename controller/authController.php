<?php
    require_once("userController.php");
    
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) 
    {
     

        $user = [
            "user_id" => $_POST["userId"],
            "name"    => $_POST["username"],
            "role"    => $_POST["roleSelect"],
            "email"   => $_POST["email"],
            "pass"    => $_POST["pass"]
        ];

        
        $result = registeringUser($user);

        if ($result) {
            header("Location: ../view/login.php");
        } else {
            echo "Error in registration.";
        }
    }
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["login"]))
    {
        $user = [
            "user_id" => $_POST["userId"],
            "pass"    => $_POST["pass"]
        ];
        
        $result = login($user);
        if($result)
        {
            
        }
        else
        {
            echo "Login Failed.";
        }
    }
    



?>