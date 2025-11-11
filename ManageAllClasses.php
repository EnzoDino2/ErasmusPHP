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
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2>Class Management</h2>
    <?php
    require_once "database.php"; 
    
    $sql = "SELECT class_id, class_name, study_programme, id_code, credits, max_capacity, availability_datetime, availability_dateendtime FROM classes";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table class='table table-hover'>";
        echo "<thead class='thead-dark'><tr><th>Class Name</th><th>study programme</th><th>ID Code</th><th>Credits</th><th>Max Capacity</th><th>Availability Start</th><th>Availability End</th><th>Actions</th></tr></thead><tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td><a href='ViewClassEnrollments.php?class_id=" . htmlspecialchars($row['class_id']) . "'>" . htmlspecialchars($row['class_name']) . "</a></td>
                    <td>" . htmlspecialchars($row['study_programme']) . "</td>
                    <td>" . htmlspecialchars($row['id_code']) . "</td>
                    <td>" . htmlspecialchars($row['credits']) . "</td>
                    <td>" . htmlspecialchars($row['max_capacity']) . "</td>
                    <td>" . htmlspecialchars($row['availability_datetime']) . "</td>
                    <td>" . htmlspecialchars($row['availability_dateendtime']) . "</td>
                    <td><a href='EditClass.php?class_id=" . htmlspecialchars($row['class_id']) . "' class='btn btn-primary'>Edit</a></td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No classes found</p>";
    }
    ?>
    <a href="adminDashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

</body>

</html>
