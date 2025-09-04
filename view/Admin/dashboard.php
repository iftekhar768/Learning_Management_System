<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learning_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$depts = [];
$stmt = $conn->prepare("SELECT dept_id, dept_name, dept_full_name FROM dept_catalogue ORDER BY dept_name");
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $depts[] = $row;
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="dashboard.css" />
    <style>
   
    </style>
</head>
<body>
    <main class="management-section">
        <h2>Course Management Dashboard</h2>

        <section class="container">
            <div class="box">
                <a href="#">Box 1</a>
            </div>
            <div class="box">
                <a href="#">Box 2</a>
            </div>
            <div class="box">
                <a href="#">Box 3</a>
            </div>
        </section>

        <section class="course-list-section">
            <div class="department-tabs" id="dept-tabs">
                <?php if (count($depts) === 0): ?>
                    <div>No departments found. Add departments to <code>dept_catalogue</code>.</div>
                <?php else: ?>
                    <?php foreach ($depts as $i => $d): ?>
                        <button class="tab-btn" data-dept="<?php echo (int)$d['dept_id']; ?>">
                            <?php echo htmlspecialchars($d['dept_name']); ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="course-display">
                <p>Select a department to load courses.</p>
            </div>
        </section>

        <section class="form-section">
            <h3>Create Course</h3>
            <form class="course-form" id="course-form" method="POST" action="create_course.php">
                <div class="form-group">
                    <label for="course_name">Course name</label>
                    <input id="course_name" name="course_name" type="text" required />
                </div>
                <div class="form-group">
                    <label for="course_code">Course code</label>
                    <input id="course_code" name="course_code" type="text" />
                </div>
                <div class="form-group">
                    <label for="dept_select_for_course">Department</label>
                    <select id="dept_select_for_course" name="dept_id" required>
                        <option value="">Select department</option>
                        <?php foreach ($depts as $d): ?>
                            <option value="<?php echo (int)$d['dept_id']; ?>"><?php echo htmlspecialchars($d['dept_name'] . ' - ' . $d['dept_full_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="course_description">Description</label>
                    <textarea id="course_description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="course_credits">Credits</label>
                    <input id="course_credits" name="credits" type="number" min="0" value="3" />
                </div>

                <button class="btn-primary" type="submit">Create Course</button>
            </form>
        </section>

        <section class="form-section">
            <h3>Assign Teacher</h3>
            <form class="assign-form" id="assign-form" method="POST" action="assign_teacher.php">
                <div class="form-group">
                    <label for="teacher_select">Teacher</label>
                    <select id="teacher_select" name="teacher_id" required>
                        <option value="">Select teacher</option>
                       
                    </select>
                </div>

                <div class="form-group">
                    <label for="course_select_assign">Course</label>
                    <select id="course_select_assign" name="course_id" required>
                        <option value="">First select a department tab to load courses</option>
                    </select>
                </div>

                <button class="btn-primary" type="submit">Assign</button>
            </form>
        </section>

        <section class="calendar">
            <div class="calendar-header">
                <button id="prev" aria-label="Previous month">&lt;</button>
                <div id="month-year"></div>
                <button id="next" aria-label="Next month">&gt;</button>
            </div>
            <div id="calendar-days" class="calendar-days"></div>
        </section>
    </main>

    <script src="dashboard.js"></script>
</body>
</html>
