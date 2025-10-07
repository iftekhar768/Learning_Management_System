<?php
session_start();
require_once("../../model/teacherModel.php");

// Assuming teacher_id is stored in session after login
$teacherId = $_SESSION['teacher_name'] ?? 1; // Replace with actual session value


// Get teacher statistics
$teacherCourses = getTeacherCourses($teacherId);
$totalCourses = count($teacherCourses);
$totalStudents = getTotalStudentsInTeacherCourses($teacherId);
$totalQuizzes = getTotalTeacherQuizzes($teacherId);
$totalAssignments = getTotalTeacherAssignments($teacherId);

// Get recent activities
$recentCourses = array_slice($teacherCourses, 0, 5);
?>

<link rel="stylesheet" href="../../assets/css/teacher/dashboard.css">

<div class="dashboard-container">
    <h1>Teacher Dashboard</h1>
    <p class="welcome-text">Welcome back, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Teacher'); ?>!</p>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-courses">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>My Courses</h3>
                <p class="stat-number"><?php echo $totalCourses; ?></p>
            </div>
        </div>

        <div class="stat-card stat-students">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Students</h3>
                <p class="stat-number"><?php echo $totalStudents; ?></p>
            </div>
        </div>

        <div class="stat-card stat-quizzes">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 11l3 3L22 4"></path>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Quizzes</h3>
                <p class="stat-number"><?php echo $totalQuizzes; ?></p>
            </div>
        </div>

        <div class="stat-card stat-assignments">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Assignments</h3>
                <p class="stat-number"><?php echo $totalAssignments; ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="actions-grid">
            <a href="#" class="action-btn" data-page="create_course.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Create New Course
            </a>
            <a href="#" class="action-btn" data-page="quizzes.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 11l3 3L22 4"></path>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                Create Quiz
            </a>
            <a href="#" class="action-btn" data-page="announcements.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                Post Announcement
            </a>
            <a href="#" class="action-btn" data-page="assignments.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                Create Assignment
            </a>
        </div>
    </div>

    <!-- My Courses -->
    <div class="my-courses-section">
        <h2>My Courses</h2>
        <?php if ($recentCourses && count($recentCourses) > 0): ?>
            <div class="courses-grid">
                <?php foreach ($recentCourses as $course): ?>
                    <div class="course-card">
                        <div class="course-header">
                            <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                            <span class="course-status <?php echo $course['is_active'] ? 'active' : 'inactive'; ?>">
                                <?php echo $course['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </div>
                        <p class="course-description"><?php echo htmlspecialchars($course['course_description']); ?></p>
                        <div class="course-footer">
                            <span class="course-students">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <?php echo $course['student_count'] ?? 0; ?> Students
                            </span>
                            <a href="#" class="btn-view-course" data-course-id="<?php echo $course['course_id']; ?>">View Course</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You haven't created any courses yet. <a href="#" data-page="create_course.php">Create your first course</a></p>
        <?php endif; ?>
    </div>
</div>

<script>
// Handle quick action buttons
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        // Trigger the navigation
        const event = new CustomEvent('loadPage', { detail: { page: page } });
        window.dispatchEvent(event);
    });
});
</script>