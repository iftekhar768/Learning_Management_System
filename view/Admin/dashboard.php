<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS Admin Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
  <script src="dashboard.js" defer></script>
</head>
<body>
  <div class="container">
    
    <div class="sidebar">
      <h2>Learning Management</h2>
      <ul>
        <li><a href="#">Dashboard</a></li>
      </ul>
      <h3>User Management</h3>
      <ul>
        <li><a href="#">Add New User</a></li>
        <li><a href="#">Manage Students</a></li>
        <li><a href="#">Manage Teachers</a></li>
      </ul>
      <h3>Course Management</h3>
      <ul>
        <li><a href="#">Approve Courses</a></li>
        <li><a href="#">Assign Teachers</a></li>
        <li><a href="#">Delete/Modify Courses</a></li>
      </ul>
      <h3>System Statistics</h3>
      <ul>
        <li><a href="#">Settings</a></li>
      </ul>
    </div>

   
    <div class="main">
      <div class="top-bar">
        <h1>Learning Management System</h1>
        <div class="search-admin">
          <input type="text" placeholder="Search">
          <span>👤 Admin</span>
        </div>
      </div>

      
      <div class="stats">
        <div class="card">
          <h2></h2>
          <p>Total Students</p>
        </div>
        <div class="card">
          <h2></h2>
          <p>Total Teachers</p>
        </div>
        <div class="card">
          <h2></h2>
          <p>Total Courses</p>
        </div>
        <div class="card">
          <h2></h2>
          <p>Active Quizzes</p>
        </div>
      </div>

     
      <div class="content">
        <div class="box">
          <h3>Courses by Department</h3>
          <canvas id="chart"></canvas>
        </div>
        <div class="box recent">
          <h3>Recent Activity</h3>
          
        </div>
      </div>

     
      <div class="buttons">
        <button>Add User</button>
        <button>Add Course</button>
        <button>View Reports</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
