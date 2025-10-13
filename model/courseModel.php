<?php
    require_once("database.php");
    
   function addCourse($course)
{
    $conn = getConnection();
    
    $sql = "INSERT INTO courses (course_name, course_description, teacher_id) 
            VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $course["course_name"],
        $course["course_description"],
        $course["teacher_id"]
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
    function getTotalCourses()
    {
        $conn = getConnection();
        $sql = "SELECT COUNT(*) as total FROM courses";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    function getActiveCourses()
    {
        $conn = getConnection();
        $sql = "SELECT COUNT(*) as total FROM courses WHERE is_active = 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    function getRecentCourses($limit = 5)
    {
        $conn = getConnection();
        $sql = "SELECT c.course_id, c.course_name, c.is_active, c.created_at,
                       t.name as teacher_name
                FROM courses c
                LEFT JOIN teacher_table t ON c.teacher_id = t.teacher_id
                ORDER BY c.created_at DESC
                LIMIT ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $courses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $courses;
    }
?>