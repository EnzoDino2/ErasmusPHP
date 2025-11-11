<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_id"])) {
    echo "User is not logged in.";
    exit(); 
}

if (isset($_POST["enrollment_id"]) && !empty($_POST["enrollment_id"])) {
    // Ensure $enrollment_ids is always treated as an array
    $enrollment_ids = is_array($_POST["enrollment_id"]) ? $_POST["enrollment_id"] : array($_POST["enrollment_id"]);

    foreach ($enrollment_ids as $enrollment_id) {
        $sql = "DELETE FROM enrollments WHERE enrollment_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $sql); 
        $stmt->bind_param("ii", $enrollment_id, $_SESSION["user_id"]);
        $stmt->execute();
    }
}
    header("location:SeeClasses.php");
    exit();
?>
