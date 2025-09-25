<?php
    require_once("userController.php");
    require_once("../model/userModel.php");
    
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

  

 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"]))
    {
        $user = [
            "user_id" => $_POST["userId"],
            "name"    => $_POST["username"],
            "role"    => $_POST["role"],
            "email"   => $_POST["email"],
            "pass"    => $_POST["pass"]
        ];
       $result = registeringUser($user);
       if($result)
       {

       }
       else{
        echo "insertion failed";
       }
       exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $userId = $_POST["userId"];
        $result = delUser($userId);
        if($result)
        {

        }
        else
        {
            echo "Delete failed";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
         $user = [
        "user_id" => $_POST["userId"],
        "name"    => $_POST["username"],
        "role"    => $_POST["role"],
        "email"   => $_POST["email"]
    ];
    
    $result = upUser($user);
    
    if($result) {
        
        header("Location: ../view/Admin/userManagement.php");
        exit();
    } else {
        echo "Update failed";
    }
    exit();
    }

   
    $users = getAllUsers();
    if ($users && mysqli_num_rows($users) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Name</th><th>Role</th><th>Email</th><th>Action</th></tr>";

        while ($row = mysqli_fetch_assoc($users)) {
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['role']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <button class='deleteBtn' data-id='{$row['user_id']}'>Delete</button>
                        <button class='updateBtn' data-id='{$row['user_id']}'>Update</button>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }

    exit; 




?>