<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_id"])) {
    $_SESSION['messages'][] = ['type' => 'error', 'text' => "User is not logged in."];
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION["user_id"];
$_SESSION['messages'] = []; 


if (isset($_POST['class_ids']) && is_array($_POST['class_ids'])) {
    $currentTime = new DateTime();

    foreach ($_POST['class_ids'] as $classId) {
        //check if the user is already enrolled in the class
        $checkEnrollment = "SELECT 1 FROM enrollments WHERE user_id = ? AND class_id = ?";
        $checkStmt = $conn->prepare($checkEnrollment);
        $checkStmt->bind_param("ii", $user_id, $classId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $_SESSION['messages'][] = ['type' => 'error', 'text' => "You are already enrolled in '$className'."];
            continue;
        }

        
        $classQuery = "SELECT class_name, max_capacity, availability_datetime, availability_dateendtime, 
                       (SELECT COUNT(*) FROM enrollments WHERE class_id = classes.class_id) AS current_enrolled
                       FROM classes WHERE class_id = ?";
        $classStmt = $conn->prepare($classQuery);
        $classStmt->bind_param("i", $classId);
        $classStmt->execute();
        $classResult = $classStmt->get_result();

        if ($classRow = $classResult->fetch_assoc()) {
            $className = $classRow['class_name'];
            $maxCapacity = $classRow['max_capacity'];
            $currentEnrolled = $classRow['current_enrolled'];
            $availabilityDateTime = new DateTime($classRow['availability_datetime']);
            $availabilityDateEndTime = new DateTime($classRow['availability_dateendtime']);

            // Check class availability and capacity
            if ($currentTime < $availabilityDateTime || $currentTime > $availabilityDateEndTime) {
                $_SESSION['messages'][] = ['type' => 'error', 'text' => "'$className' is not available for enrollment at this time."];
                continue;
            }

            if ($currentEnrolled >= $maxCapacity) {
                $_SESSION['messages'][] = ['type' => 'error', 'text' => "'$className' has reached its maximum capacity."];
                continue;
            }

            // Enroll the user in the class
            $insertEnrollment = "INSERT INTO enrollments (user_id, class_id) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertEnrollment);
            $insertStmt->bind_param("ii", $user_id, $classId);
            if (!$insertStmt->execute()) {
                $_SESSION['messages'][] = ['type' => 'error', 'text' => "Error enrolling in '$className'."];
            } else {
                $_SESSION['messages'][] = ['type' => 'success', 'text' => "Successfully enrolled in '$className'."];
            }
        } else {
            $_SESSION['messages'][] = ['type' => 'error', 'text' => "Class ID $classId not found."];
        }
    }
} else {
    $_SESSION['messages'][] = ['type' => 'error', 'text' => "No classes were selected for enrollment."];
}

header("Location: ClassesSelect.php");
exit();
?>
