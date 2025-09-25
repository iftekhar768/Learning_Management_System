<?php

<!DOCTYPE html>
<html>
<head>
  <title>Teacher Dashboard</title>
  <link rel="stylesheet" href="Teacherstyle.css">
</head>
<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="courses.php">Courses</a></li>
      <li><a href="quizzes.php">Quizzes</a></li>
      <li><a href="announcements.php">Announcements</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
  <div class="main">
    <h1>Teacher Dashboard</h1>
    <div class="cards">
      <div class="card">
        <img src="https://img.icons8.com/ios-filled/50/000000/open-book.png"/>
        <h3>Create and manage courses</h3>
        <p>Add lessons, upload materials</p>
      </div>
      <div class="card">
        <img src="https://img.icons8.com/ios-filled/50/000000/test.png"/>
        <h3>Create and manage quizzes</h3>
        <p>Add questions, set answers</p>
      </div>
      <div class="card">
        <img src="https://img.icons8.com/ios-filled/50/000000/megaphone.png"/>
        <h3>Post announcements</h3>
        <p>For students</p>
      </div>
    </div>
  </div>
</body>
</html>
?>