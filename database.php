<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "e_login_register";
// Create connection
   $conn = mysqli_connect($hostName, $dbUser, $dbPassword,$dbName);
   if (!$conn) {
    die("Something went wrong;");
   }
   
?>