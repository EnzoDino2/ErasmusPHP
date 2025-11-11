<?php
require_once "database.php"; 

if (isset($_POST['class_id'])) {
    // retrieve form data
    $class_id = $_POST['class_id'];
    $class_name = $_POST['class_name'];
    $id_code = $_POST['id_code'];
    $credits = $_POST['credits'];
    $max_capacity = $_POST['max_capacity'];
    $availability_datetime = $_POST['availability_datetime'];
    $availability_dateendtime = $_POST['availability_dateendtime'];
    $study_programme = $_POST['study_programme'];
    
    // Update class in the database
    $stmt = $conn->prepare("UPDATE classes SET class_name = ?, id_code = ?, credits = ?, max_capacity = ?, availability_datetime = ?, availability_dateendtime = ?, study_programme = ? WHERE class_id = ?");
    $stmt->bind_param("ssiisssi", $class_name, $id_code, $credits, $max_capacity, $availability_datetime, $availability_dateendtime, $study_programme, $class_id);

    if ($stmt->execute()) {
        echo "Class updated successfully.";
    } else {
        echo "Error updating class: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "No class ID provided.";
}
?>
