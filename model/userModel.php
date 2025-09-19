<?php
require_once("database.php");

function validateUser()
    {
        $conn=getConnection();
        $sql="SELECT * FROM user";
        $result=mysqli_query($conn,$sql);

        return mysqli_fetch_assoc($result);
        
    }

    function registerUser($user)
    {
        $conn=getConnection();
        echo var_dump($user);
        $sql = "INSERT INTO user (user_id, name, role, email, pass) 
        VALUES ('{$user["user_id"]}','{$user["name"]}','{$user["role"]}','{$user["email"]}','{$user["pass"]}')";

        $result=mysqli_query($conn,$sql);
        return $result;
    }


?>