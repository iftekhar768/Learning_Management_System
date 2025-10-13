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
    $sql = "INSERT INTO `user` (user_id, name, role, email, pass) 
            VALUES ('{$user["user_id"]}',
                    '{$user["name"]}',
                    '{$user["role"]}',
                    '{$user["email"]}',
                    '{$user["pass"]}')";
    
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Insert failed: " . mysqli_error($conn));
    }
    return $result;
}



function validateAndLogin($user)
{
    $conn = getConnection();
    $userId = $user["user_id"];
    $password = $user["pass"];
    
    if($userId === "001" && $password === "admin")
    {
        $_SESSION["user_id"] = $userId;
        $_SESSION["role"] = "admin";
        header("Location: ../view/Admin/home.php");
        exit();
        return true;
    }
  
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
function deleteUser($userId)
{
    $conn = getConnection();
    $sql = "DELETE FROM user WHERE user_id = '$userId'";
    $result= mysqli_query($conn, $sql);
    return $result;
}

function updateUser($user)
{
    $conn = getConnection();
    $sql = "UPDATE `user` 
            SET name='{$user["name"]}', 
                role='{$user["role"]}', 
                email='{$user["email"]}'
            WHERE user_id='{$user["user_id"]}'";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Update failed: " . mysqli_error($conn));
    }
    return $result;
}


function getTotalUsers()
    {
        $conn = getConnection();
        $sql = "SELECT COUNT(*) as total FROM user";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    function getTotalUsersByRole($role)
    {
        $conn = getConnection();
        $sql = "SELECT COUNT(*) as total FROM user WHERE role = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row['total'];
    }

    function getRecentUsers($limit = 5)
    {
        $conn = getConnection();
        $sql = "SELECT user_id, name, email, role, created_at 
                FROM user
                ORDER BY created_at DESC 
                LIMIT ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $users;
    }

?>