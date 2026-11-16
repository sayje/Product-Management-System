<?php

    session_start();

       // AUTO LOGIN via cookies
    if (isset($_COOKIE['username'])) {
       $_SESSION['username'] = $_COOKIE['username'];
       header("Location: index.php");
       exit;
   }


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


   $message = '';


   if ($_SERVER["REQUEST_METHOD"] == "POST" ) {


       //STEP 4: PREPARE DATA FROM THE FORM
       $username = mysqli_real_escape_string($conn, $_POST['username']);
       $password = $_POST['password'];  


       //STEP5: SQL QUERY TO SELECT CORRECT USERNAME
       $result = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username='$username' LIMIT 1");


    if ( mysqli_num_rows($result) == 1 ) {


           //if true, check password
          $user = mysqli_fetch_assoc($result);
          //var_dump($user);
            if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
                // REMEMBER ME (cookie)
               if (isset($_POST['remember'])) {
                   setcookie("username", $user['username'], time() + (86400 * 7), "/"); // 7 days
               }
               header("Location: index.php");
               exit;


           } else {
               $message = "Invalid password!";


           }

       } else {

           //if false, user not found.
           $message = "User not found!";

       }
    }




?>


<!DOCTYPE html>
<html>
   <head>
   <title>Login</title>
   <link rel="stylesheet" href="style.css">
   </head>
   <body>


       <div class="container">
       <h2>Login</h2>
       <p style="color:red;"><?php echo $message; ?></p>


           <form method="POST">
           <input class="username" type="text" name="username" placeholder="Username" required>
           <input class="password" type="password" name="password" placeholder="Password" required>


           <label>
           <input class="checkbox" type="checkbox" name="remember"> Remember Me
           </label>


           <button class="button" type="submit">Login</button>
           </form>
       </div>


   </body>
</html>


