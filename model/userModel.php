<?php
require_once("database.php");

function validateUser()
{
    $conn = getConnection();
    $sql = "SELECT * FROM user";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function registerUser($user)
{
    $conn = getConnection();
    $sql = "INSERT INTO user (user_id, name, role, email, pass) 
            VALUES ('{$user["user_id"]}','{$user["name"]}','{$user["role"]}','{$user["email"]}','{$user["pass"]}')";
    
    $result = mysqli_query($conn, $sql);
    return $result;
}

function validateAndLogin($user)
{
    $conn = getConnection();
    $userId = $user["user_id"];
    $password = $user["pass"];
    
  
    $sql = "SELECT user_id, role FROM user WHERE user_id = '$userId' AND pass = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0)
    {
        $userData = mysqli_fetch_assoc($result);
        $role = $userData["role"];
        
       
        $_SESSION["user_id"] = $userId;
        $_SESSION["role"] = $role;
        
      
        if($role === "teacher")
        {
            header("Location: ../view/Teacher/home.php");
            exit();
        }
        elseif($role === "student")
        {
            header("Location: ../view/Student/home.php");
            exit();
        }
        return true;
    }
    else
    {
        return false; 
    }
}
?>