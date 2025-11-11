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
    <title>Set Class Availability</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Set Class Availability</h2>
        <form action="set_class_availability.php" method="post">
            <div class="form-group">
                <label for="class_id">Select Class:</label>
                <select class="form-control" id="class_id" name="class_id">
                    
                    <?php
                    require 'database.php'; 
                    $sql = "SELECT class_id, class_name FROM classes";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['class_id']}'>{$row['class_name']}</option>";
                        }
                    } else {
                        echo "<option>No classes found</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="availability_datetime">Availability Date and Time:</label>
                <input type="datetime-local" class="form-control" id="availability_datetime" name="availability_datetime" required>
            </div>
            <button type="submit" class="btn btn-primary">Set Availability</button>
        </form>
    </div>
</body>
</html>
