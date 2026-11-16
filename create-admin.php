<?php
session_start();


// Database connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'product_list');


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}


// Initialize message
$message = "";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {


   // Get and sanitize input
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $email    = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];


   // Hash password
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);


   // Insert query
   $sql = "INSERT INTO tbl_admin (username, email, password, date_added)
           VALUES ('$username', '$email', '$hashed_password', NOW())";


   if (mysqli_query($conn, $sql)) {       
      header("Location: index.php");       
      exit();   
      }else {     
         $message = "Error: " . mysqli_error($conn);
         }
}


?>


<!DOCTYPE html>
<html>
<head>
   <title>Admin Registration</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">   
   <a href="index.php" class="nav-link" style="background: #3498db;">← Back to Dashboard</a>  
   <h2>Register Admin</h2>


   <?php if ($message != ""): ?>
       <p class="message"><?php echo $message; ?></p>
   <?php endif; ?>


   <form method="POST" action="">
       <input class="username "type="text" name="username" placeholder="Username" required>
       <input class="email" type="email" name="email" placeholder="Email Address" required>
       <input class="password" type="password" name="password" placeholder="Password" required>


       <button type="submit">Register</button>
   </form>
</div>


</body>
</html>
