<?php
session_start();
define('BASE_URL', 'http://localhost/finals');

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
//echo 'Connected successfully!';

// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Total count
$count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM `tbl_admin`");
$total_row = mysqli_fetch_assoc($count_result);
$total_account = $total_row['total'];
$total_pages = ceil($total_account / $limit);

//STEP 4: MAKE SQL QUERY TO SELECT DATA FROM DATABASE TABLE
$sql = "SELECT * FROM `tbl_admin` ORDER BY id ASC LIMIT $limit OFFSET $offset";

//STEP 5: EXECUTE QUERY & GET THE RESULT
$result = mysqli_query($conn, $sql);

//STEP 6: FETCH DATA FROM RESULT AS ASSOCIATIVE ARRAY
$accounts = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin List</title>
   <link rel="stylesheet" href="../style.css">
   <link rel="stylesheet" href="style.css">
</head>

<body class="list-page">
   <div class="container list-container">        
    <div style="margin-bottom: 20px;">            
        <a href="index.php" class="nav-link" style="background: #3498db; display: inline-block;">← Back to Dashboard</a>           
        <a href="create-admin.php" class="nav-link" style="background: #27ae60; display: inline-block; margin-left: 10px;">+ Add New Account</a>        
    </div>       
    <h1>Admin List</h1>

       <table>
       <thead>
           <tr>
               <th>#</th>
               <th>Username</th>
               <th>Email</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody>
           <?php
           $ctr = ($page - 1) * $limit + 1;
           foreach( $accounts as $account ): ?>
               <tr>
                   <td><?=$ctr++;?></td>
                   <td><?=$account['username'];?></td>
                   <td><?=$account['email'];?></td>
                   <td>
                        <a href="update-admin.php?id=<?= $account['id']; ?>" class="edit-link">Edit</a>
                        <a onclick="return confirm('Are you sure you want to delete account \"<?= $account['username']; ?>\" ?')" href="delete-list.php?id=<?= $account['id']; ?>" class="delete-link">Delete</a>
                    </td>
               </tr>
           <?php endforeach; ?>
       </tbody>
       </table>

        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="nav-link">← Previous</a>
            <?php endif; ?>
            <span class="page-num">Page <?= $page ?> of <?= $total_pages ?></span>
            <?php if($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="nav-link">Next →</a>
            <?php endif; ?>
            <?php if($total_account === 0): ?>
                <p>No admin accounts found. <a href="create-admin.php">Create the first account</a></p>
            <?php endif; ?>
        </div>
   </div>
</body>
</html>

