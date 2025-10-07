<?php
    require_once("courseController.php");

    if (isset($_GET['search'])) {
        $searchTerm = trim($_GET['search']);
        
        if (strlen($searchTerm) > 0) {
            $teachers = getTeachers($searchTerm);
            header('Content-Type: application/json');
            echo json_encode($teachers);
        } else {
            echo json_encode([]);
        }
    }
?>