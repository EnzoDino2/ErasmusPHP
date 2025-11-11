<?php
session_start(); 


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); 
    exit; 
}

require_once "database.php"; 

if (isset($_POST["submit"])) {
    $class_name = $_POST["class_name"];
    $id_code = $_POST["id_code"];
    $credits = $_POST["credits"];
    $max_capacity = $_POST["max_capacity"];
    $availability_datetime = $_POST["availability_datetime"];
    $availability_dateendtime = $_POST["availability_dateendtime"];
    $study_programme = $_POST["study_programme"];

    if (empty($class_name) || empty($id_code) || empty($credits) || empty($max_capacity) || empty($availability_datetime) || empty($availability_dateendtime) || empty($study_programme)) {
        echo "<p>Please fill in all fields correctly.</p>";
    } else {
        $sql = "INSERT INTO classes (class_name, id_code, credits, max_capacity, availability_datetime, availability_dateendtime, study_programme) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiisss", $class_name, $id_code, $credits, $max_capacity, $availability_datetime, $availability_dateendtime, $study_programme);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Class added successfully!</p>";
        } else {
            echo "<p>Error adding class: " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
