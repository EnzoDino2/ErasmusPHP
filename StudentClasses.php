<?php
session_start(); 


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    header('Location: login.php');
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
    <title>Student Classes</title>
    <style>
        .class-list {
            list-style-type: none;
            padding: 0;
        }
        .class-list li {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 10px;
            margin-bottom: 10px;
            color: black; 
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <?php
    require 'database.php'; 
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die("Student ID is required");

    // fetch the students name
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student_name = $result->num_rows ? $result->fetch_assoc()['full_name'] : 'Unknown Student';

    echo "<h2>Classes for {$student_name}</h2>";

    // fetch and display the classes for this student
    $sql = "SELECT classes.class_name, classes.id_code FROM enrollments JOIN classes ON enrollments.class_id = classes.class_id WHERE enrollments.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul class='class-list'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['class_name']} ({$row['id_code']})</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>This student is not enrolled in any classes.</p>";
    }

    $conn->close();
    ?>
    <a href="SeeStudents.php" class="btn btn-primary">Back to Students List</a>
</div>
</body>
</html>
