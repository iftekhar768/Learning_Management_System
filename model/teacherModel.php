<?php
    require_once("database.php");
    
    function getTeacherCourses($teacherId)
    {
        $conn = getConnection();
        
        $sql = "SELECT c.*, 
                       (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.course_id) as student_count
                FROM courses c
                WHERE c.teacher_id = ?
                ORDER BY c.created_at DESC";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $teacherId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $courses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $courses;
    }

    function getTotalStudentsInTeacherCourses($teacherId)
    {
        $conn = getConnection();
        
        $sql = "SELECT COUNT(DISTINCT e.student_id) as total
                FROM enrollments e
                INNER JOIN courses c ON e.course_id = c.course_id
                WHERE c.teacher_id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $teacherId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row['total'] ?? 0;
    }

    function getTotalTeacherQuizzes($teacherId)
    {
        $conn = getConnection();
        
        $sql = "SELECT COUNT(*) as total
                FROM quizzes q
                INNER JOIN courses c ON q.course_id = c.course_id
                WHERE c.teacher_id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $teacherId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row['total'] ?? 0;
    }

    function getTotalTeacherAssignments($teacherId)
    {
        $conn = getConnection();
        
        $sql = "SELECT COUNT(*) as total
                FROM assignments a
                INNER JOIN courses c ON a.course_id = c.course_id
                WHERE c.teacher_id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $teacherId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row['total'] ?? 0;
    }
    function getTeacherIdByUserId($userId)
{
    $conn = getConnection();
    
    $sql = "SELECT teacher_id FROM teacher_table WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['teacher_id'] ?? null;
}

function addLesson($lessonData)
    {
        $conn = getConnection();
        
        $sql = "INSERT INTO lessons (course_id, lesson_title, lesson_content, lesson_order) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            return false;
        }
        
        mysqli_stmt_bind_param($stmt, "issi", 
            $lessonData["course_id"],
            $lessonData["lesson_title"],
            $lessonData["lesson_content"],
            $lessonData["lesson_order"]
        );
        
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }

    function addCourseMaterial($materialData)
    {
        $conn = getConnection();
        
        $sql = "INSERT INTO course_materials (course_id, material_title, file_path, file_type) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            return false;
        }
        
        mysqli_stmt_bind_param($stmt, "isss", 
            $materialData["course_id"],
            $materialData["material_title"],
            $materialData["file_path"],
            $materialData["file_type"]
        );
        
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $result;
    }

    function getCourseLessons($courseId)
    {
        $conn = getConnection();
        
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_order ASC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $courseId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $lessons = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lessons[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $lessons;
    }

    function getCourseMaterials($courseId)
    {
        $conn = getConnection();
        
        $sql = "SELECT * FROM course_materials WHERE course_id = ? ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $courseId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $materials = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $materials[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $materials;
    }
?>