<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enrollments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php
    if (isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];
        require_once "database.php"; 

        // Fetch class name for display
        $classNameQuery = $conn->prepare("SELECT class_name FROM classes WHERE class_id = ?");
        $classNameQuery->bind_param("i", $class_id);
        $classNameQuery->execute();
        $classNameResult = $classNameQuery->get_result();
        $classNameRow = $classNameResult->fetch_assoc();
        $class_name = $classNameRow ? $classNameRow['class_name'] : "Class ID $class_id";

        echo "<h2>Enrollments for ".htmlspecialchars($class_name)."</h2>";

        // fetch the enrolled students
        $enrollmentsQuery = $conn->prepare("SELECT user_id, full_name FROM users u JOIN enrollments  ON user_id = user_id WHERE class_id = ?");
        $enrollmentsQuery->bind_param("i", $class_id);
        $enrollmentsQuery->execute();
        $result = $enrollmentsQuery->get_result();

        if ($result->num_rows > 0) {
            echo "<ul class='list-group'>";
            while($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item'>".htmlspecialchars($row['full_name'])."</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No students are currently enrolled in this class.</p>";
        }
    } else {
        echo "<p>Class ID not specified.</p>";
    }
    ?>
    <a href="ManageClasses.php" class="btn btn-secondary mt-3">Back to Class Management</a>
</div>
</body>
</html>
