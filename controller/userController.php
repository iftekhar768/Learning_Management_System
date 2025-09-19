<?php
    require_once("../model/userModel.php");

    function registeringUser($user)
    {
        return registerUser($user);
    }

    function login($user) 
    {
        return validateAndLogin($user);
    }
?>