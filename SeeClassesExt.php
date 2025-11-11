<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_id"])) {
    echo "User is not logged in.";
    exit();
}

$user_id = $_SESSION["user_id"];


$sql = "SELECT c.class_id, c.class_name, c.id_code, c.credits, c.max_capacity, e.enrollment_id
        FROM enrollments e
        JOIN classes c ON e.class_id = c.class_id
        WHERE e.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
