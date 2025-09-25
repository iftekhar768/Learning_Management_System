<?php
     require_once(__DIR__ . "/../model/userModel.php");

    function registeringUser($user)
    {
        return registerUser($user);
    }

    function login($user) 
    {
        return validateAndLogin($user);
    }
    function upUser($user)
    {
        return updateUser($user);
    }
    function delUser($userId)
    {
        return deleteUser($userId);
    }
?>