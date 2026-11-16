<?php
session_start();


// Check session or cookie
if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {
   header("Location: login.php");
   exit;
}


// Restore session from cookie
if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
   $_SESSION['username'] = $_COOKIE['username'];
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<p>You are logged in.</p>


<div class="actions">
   <a href="create-admin.php" class="btn_create">CREATE</a>
   <a href="admin-list.php" class="btn_read">READ</a>
   <a href="admin-list.php" class="btn_update">UPDATE</a>
   <a href="admin-list.php" class="btn_delete">DELETE</a>
<br>
<a href="logout.php" class="logout">Logout</a>
</div>

</div>

</body>
</html>

