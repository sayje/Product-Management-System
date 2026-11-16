<?php
//STEP 1: DECLARE DATABASE CREDENTIALS
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'product_list');

//STEP 2: CREATE DATABASE CONNECTION
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//STEP 3: CHECK DATABASE CONNECTION
if(!$conn) {
    die('Connection Failed' . mysqli_connect_error());
    exit();
}

// Fetch admin first if ID present
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //STEP 4: MAKE SQL QUERY TO SELECT DATA FROM DATABASE
    $sql = "SELECT * FROM `tbl_admin` WHERE `id` = '$id'";

    //STEP 5: EXECUTE QUERY & GET THE RESULT
    $result = mysqli_query($conn, $sql);

    if ($result) {
        //STEP 6: FETCH THE RESULT
        $admin = mysqli_fetch_assoc($result);
    } else {
        echo 'Error';
    }
}

//Handle Form Submission
if (isset($_POST['submit'])) {
    //STEP 4: PREPARE DATA FROM THE FORM
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    //STEP5: MAKE SQL QUERY TO INSERT DATA INTO DATABASE TABLE
    $sql = "UPDATE `tbl_admin` SET `username` = '$username', `email` = '$email', `password` = '$password' WHERE `id` = '$id'";

    //STEP 6: EXECUTE SQL QUERY
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: admin-list.php');
        exit();
    } else {
        echo 'Error:'.$sql.'<br>'.mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $sql = "DELETE FROM `tbl_admin` WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin-list.php');
        exit();
    } else {
        echo 'Delete error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="admin-list.php" class="nav-link">← Back to Admin List</a>
        <h2>Edit Admin</h2>
        <form action="<?=$_SERVER['PHP_SELF'];?>?id=<?=$_GET['id'];?>" method="POST">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Username" value="<?= $admin['username'] ?? ''; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Email Address" value="<?= $admin['email'] ?? ''; ?>" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="New Password (leave blank to keep current)" value="">

            <button type="submit" name="submit">Update Admin</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this admin account?')">Delete Admin</button>
            <button type="button" onclick="window.location.href='admin-list.php'">Cancel</button>
        </form>
    </div>
</body>
</html>

