<?php

require 'database.php';


if (isset($_POST['class_id']) && isset($_POST['availability_datetime'])) {
    
    $classId = $_POST['class_id'];
    $availabilityDatetime = $_POST['availability_datetime'];

   
    $availabilityDatetime = str_replace("T", " ", $availabilityDatetime);

    // SQL statement to update class availability
    $sql = "UPDATE classes SET availability_datetime = ? WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $availabilityDatetime, $classId);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Class availability updated successfully.";
    } else {
        echo "Error updating class availability.";
    }
} else {
    echo "Required data not submitted.";
}
?>
