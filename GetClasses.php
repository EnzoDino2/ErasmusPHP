<?php
require_once "database.php"; 

// Get current date and time in the same format as your database
/*// Modify the query to select only classes that are currently available
$sqldatestart = "SELECT * FROM classes WHERE availability_datetime <= ?";
$stmtdatestart = $conn->prepare($sqldatestart);
$stmtdatestart->bind_param("s", $currentDateTime);
$stmtdatestart->execute();
$resultdatestart = $stmtdatestart->get_result();

$sqldateend = "SELECT * FROM classes WHERE availability_dateendtime <= ?";
$stmtdateend = $conn->prepare($sqldateend);
$stmtdateend->bind_param("s", $currentDateTime);
$stmtdateend->execute();
$resultdateend = $stmtdateend->get_result();*/

$currentDateTime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM classes WHERE availability_datetime <= ? AND availability_dateendtime >= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentDateTime, $currentDateTime);
$stmt->execute();
$result = $stmt->get_result();



?>