<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/admin/search.css">
    <script src="../../assets/js/admin/search.js" defer></script>
    <title>Document</title>
</head>
<body>
    <h1>Course Management</h1>
    <form action="../../controller/authController.php" method="POST">
        <input type="text" name="course_name" placeholder="course_name" required>
        <input type="text" name="course_description" placeholder="course_description">

        <input type="search" id="teacherSearch" name="search" placeholder="Teacher name" autocomplete="off">
        <div id="suggestions"></div>
    </form>
</body>
</html>