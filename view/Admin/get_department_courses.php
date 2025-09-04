<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_table";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo "<p>Connection failed</p>";
    exit;
}

header('Content-Type: text/html; charset=utf-8');

if (!isset($_GET['dept_id'])) {
    echo "<p>Department not specified.</p>";
    $conn->close();
    exit;
}

$dept_id = (int)$_GET['dept_id'];

$stmt = $conn->prepare("SELECT dept_name, dept_full_name FROM dept_catalogue WHERE dept_id = ?");
if (!$stmt) {
    echo "<p>Prepared statement error</p>";
    $conn->close();
    exit;
}
$stmt->bind_param("i", $dept_id);
$stmt->execute();
$dept_result = $stmt->get_result();

if ($dept_result && $dept_result->num_rows > 0) {
    $dept = $dept_result->fetch_assoc();
    echo "<h4>Courses in " . htmlspecialchars($dept['dept_name'] . " - " . $dept['dept_full_name']) . "</h4>";

    $sql = "SELECT c.course_id, c.course_name, c.course_code, c.description, c.credits,
                   u.user_name as teacher_name
            FROM courses c
            LEFT JOIN teacher_course_assignments tca ON c.course_id = tca.course_id AND tca.status = 'active'
            LEFT JOIN user_table u ON tca.teacher_id = u.user_id
            WHERE c.dept_id = ?
            ORDER BY c.course_name";

    $stmt2 = $conn->prepare($sql);
    if ($stmt2) {
        $stmt2->bind_param("i", $dept_id);
        $stmt2->execute();
        $result = $stmt2->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='course-item'>";
                echo "<div class='course-info'>";
                echo "<h4>" . htmlspecialchars($row['course_name'] . " (" . $row['course_code'] . ")") . "</h4>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<small>Credits: " . htmlspecialchars($row['credits']) . "</small>";
                if (!empty($row['teacher_name'])) {
                    echo "<br><small><strong>Assigned to:</strong> " . htmlspecialchars($row['teacher_name']) . "</small>";
                } else {
                    echo "<br><small><em>No teacher assigned</em></small>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No courses found in this department.</p>";
        }
        $stmt2->close();
    } else {
        echo "<p>Error preparing course list.</p>";
    }
} else {
    echo "<p>Department not found.</p>";
}

$stmt->close();
$conn->close();
?>
