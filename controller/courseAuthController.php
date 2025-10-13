<?php
    require_once("courseController.php");
    require_once("../model/courseModel.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCourse"])) 
    {
        
        if (empty($_POST["course_name"]) || empty($_POST["teacher_id"])) {
            header("Location: ../view/Admin/courses.php?error=All fields are required");
            exit();
        }

        $course = [
            "course_name"        => trim($_POST["course_name"]),
            "course_description" => trim($_POST["course_description"]),
            "teacher_id"         => intval($_POST["teacher_id"])
        ];

        $result = addingCourse($course);
        
        if ($result) {
            header("Location: ../view/Admin/courses.php?success=1");
            exit();
        } else {
            header("Location: ../view/Admin/courses.php?error=Adding failed");
            exit();
        }
    } else {
        header("Location: ../view/Admin/courses.php");
        exit();
    }
?>