<?php
session_start();
require_once("../../model/courseModel.php");
require_once("../../model/userModel.php");


$totalUsers = getTotalUsers();
$totalStudents = getTotalUsersByRole('student');
$totalTeachers = getTotalUsersByRole('teacher');
$totalCourses = getTotalCourses();
$activeCourses = getActiveCourses();
$inactiveCourses = $totalCourses - $activeCourses;


$recentUsers = getRecentUsers(5);
$recentCourses = getRecentCourses(5);
?>

<link rel="stylesheet" href="../../assets/css/admin/dashboard.css">

<div class="dashboard-container">
    <h1>Dashboard</h1>
    <p class="welcome-text">Welcome to the Admin Dashboard</p>

   
    <div class="stats-grid">
        <div class="stat-card stat-users">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Users</h3>
                <p class="stat-number"><?php echo $totalUsers; ?></p>
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

        <div class="stat-card stat-teachers">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Teachers</h3>
                <p class="stat-number"><?php echo $totalTeachers; ?></p>
            </div>
        </div>

        <div class="stat-card stat-courses">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Courses</h3>
                <p class="stat-number"><?php echo $totalCourses; ?></p>
            </div>
        </div>

        <div class="stat-card stat-active">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Active Courses</h3>
                <p class="stat-number"><?php echo $activeCourses; ?></p>
            </div>
        </div>

        <div class="stat-card stat-inactive">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Inactive Courses</h3>
                <p class="stat-number"><?php echo $inactiveCourses; ?></p>
            </div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <h2>User Distribution</h2>
            <canvas id="userChart"></canvas>
        </div>

        <div class="chart-card">
            <h2>Course Status</h2>
            <canvas id="courseChart"></canvas>
        </div>
    </div>

    
    <div class="recent-section">
        <div class="recent-card">
            <h2>Recent Users</h2>
            <div class="table-responsive">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recentUsers && count($recentUsers) > 0): ?>
                            <?php foreach ($recentUsers as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td>
                                        <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No recent users</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="recent-card">
            <h2>Recent Courses</h2>
            <div class="table-responsive">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Teacher</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recentCourses && count($recentCourses) > 0): ?>
                            <?php foreach ($recentCourses as $course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                    <td><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $course['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $course['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($course['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No recent courses</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const userCtx = document.getElementById('userChart').getContext('2d');
const userChart = new Chart(userCtx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Teachers', 'Admins'],
        datasets: [{
            data: [
                <?php echo $totalStudents; ?>,
                <?php echo $totalTeachers; ?>,
                <?php echo $totalUsers - $totalStudents - $totalTeachers; ?>
            ],
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#7c3aed'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

// Course Status Chart
const courseCtx = document.getElementById('courseChart').getContext('2d');
const courseChart = new Chart(courseCtx, {
    type: 'pie',
    data: {
        labels: ['Active Courses', 'Inactive Courses'],
        datasets: [{
            data: [
                <?php echo $activeCourses; ?>,
                <?php echo $inactiveCourses; ?>
            ],
            backgroundColor: [
                '#10b981',
                '#ef4444'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});
</script>