<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js" defer></script>
    <title>Document</title>
</head>
<body>
    <?php
      echo "<h1>Welcome Admin</h1>"; 
    ?>

    <div class="container">
        <div class="box"><a href="">Total Student</a></div>
        <div class="box"><a href="">Total Teacher</a></div>
        <div class="box"><a href="">Total Subject</a></div>
    </div>
    <div class="calendar">
        <div class="calendar-header">
            <button id="prev">&#10094;</button>
            <h3 id="month-year"></h3>
            <button id="next">&#10095;</button>
        </div>
    <div class="calendar-days" id="calendar-days"></div>
    </div>

    
</body>
</html>