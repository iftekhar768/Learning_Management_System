<?php
require_once("../../model/userModel.php");

session_start();

$conn = getConnection();
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="../../assets/css/admin/user.css">
</head>
<body>
   
    <h2>User Management</h2>
    <form action="../../controller/authController.php" method="POST">
        <input type="text" name="userId" placeholder="User ID" required>
        <input type="text" name="username" placeholder="Name" required>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="pass" placeholder="Password" required>
        <button type="submit" name="insert" value="insert">Insert</button>
    </form>

  >
    <h2>All Users</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
             
                <form action="../../controller/authController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="userId" value="<?= $row['user_id'] ?>">
                    <button type="submit" name="edit" value="edit">Edit</button>
                </form>

                
                <form action="../../controller/authController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="userId" value="<?= $row['user_id'] ?>">
                    <button type="submit" name="delete" value="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
