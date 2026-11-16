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
   } else {
       echo 'connected';
   }


   if ( isset($_GET['id']) ) {


       $id = $_GET['id'];


       //STEP 4: MAKE SQL QUERY TO DELETE DATA INTO DATABASE
       $sql = "DELETE FROM `tbl_admin` WHERE `id` = '$id'";


       //STEP 5: EXECUTE QUERY AND GET THE RESULT
       $result = mysqli_query($conn, $sql);


       if ( $result ) {
           echo 'Product has been deleted successfully.';
        header('Location: admin-list.php');

       } else {
           echo 'Error';
       }


   }


?>