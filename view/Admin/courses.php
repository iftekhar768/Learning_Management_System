<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <link rel="stylesheet" href="../../assets/css/admin/search.css">
    <script src="../../assets/js/admin/search.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Course Management</h1>

        <?php
        if (isset($_GET['success'])) {
            echo "<p style='color: green;'>Course added successfully!</p>";
        } elseif (isset($_GET['error'])) {
            echo "<p style='color: red;'>Error: " . htmlspecialchars($_GET['error']) . "</p>";
        }
        ?>

        <form action="../../controller/courseAuthController.php" method="POST" class="course-form">
            <input type="text" id="course_name" name="course_name" placeholder="Course Name" required>
            <input type="text" id="course_description" name="course_description" placeholder="Course Description">

            <div class="search-box">
                <input type="search" id="teacherSearch" placeholder="Search Teacher..." autocomplete="off">
                <input type="hidden" id="teacher_id" name="teacher_id" required>
                <div id="suggestions" class="suggestions-box"></div>
            </div>

            <button type="submit" name="addCourse" value="addCourse" id="AddCourse">Add Course</button>
        </form>
    </div>
</body>
</html>
