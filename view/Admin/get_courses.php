<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_table";

header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([]);
    exit;
}

if (!isset($_GET['dept_id'])) {
    echo json_encode([]);
    $conn->close();
    exit;
}

$dept_id = (int)$_GET['dept_id'];

$stmt = $conn->prepare("SELECT course_id, course_name, course_code FROM courses WHERE dept_id = ? ORDER BY course_name");
if (!$stmt) {
    echo json_encode([]);
    $conn->close();
    exit;
}
$stmt->bind_param("i", $dept_id);
$stmt->execute();
$res = $stmt->get_result();

$courses = [];
if ($res) {
    while ($row = $res->fetch_assoc()){
        $courses[] = $row;
    }
}

echo json_encode($courses);
$stmt->close();
$conn->close();
?>
