<?php
   $host = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'learning_management';
    $port = 3306;

    function getConnection()
    {
        global $host, $username, $password, $db, $port;

        $conn = mysqli_connect($host, $username, $password, $db, $port);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }


?>
