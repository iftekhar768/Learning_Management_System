<?php
    require_once(__DIR__ . "/../model/courseModel.php");

    function addingCourse($course)
    {
        return addCourse($course);
    }

    function getTeachers($searchTerm)
    {
        return searchTeachers($searchTerm);
    }
?>