<?php
    require_once(__DIR__ . "/../model/courseModel.php");

    function addingCourse($user)
    {
        return addCourse($user);
    }

    function getTeachers($searchTerm)
    {
        return searchTeachers($searchTerm);
    }
?>