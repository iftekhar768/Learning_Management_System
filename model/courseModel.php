<?php
    require_once("database.php");
    
    function addCourse($user)
    {
        $conn = getConnection();
        
        $sql = "INSERT INTO courses (course_name, course_description, teacher_id) 
                VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ssi", 
            $user["course_name"],
            $user["course_description"],
            $user["teacher_id"]
        );
        
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        return $result;
    }

    function searchTeachers($searchTerm)
    {
        $conn = getConnection();
        $searchTerm = "%" . $searchTerm . "%";
        
        $sql = "SELECT teacher_id, name, email FROM teacher_table WHERE name LIKE ? OR email LIKE ? LIMIT 10";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $teachers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $teachers[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $teachers;
    }
?>