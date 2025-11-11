<?php
session_start(); 


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); 
    exit; 
}

require_once "database.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
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
        echo "<script>alert('Class updated successfully.'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Error updating class: {$conn->error}');</script>";
    }
    $stmt->close();
    $conn->close();

    // Redirect to avoid form resubmission
    header("Location: EditClass.php?class_id={$class_id}");
    exit;
}

// Fetch class details if not processing a form submission.
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $stmt = $conn->prepare("SELECT * FROM classes WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $class = $result->fetch_assoc();

    if (!$class) {
        echo "Class not found.";
        exit;
    }
} else {
    echo "No class ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Class Details</h2>
    <form action="EditClass.php" method="post" class="mt-3">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class['class_id']); ?>">

        <div class="form-group">
            <label for="class_name">Class Name</label>
            <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="id_code">ID Code</label>
            <input type="text" class="form-control" id="id_code" name="id_code" value="<?php echo htmlspecialchars($class['id_code']); ?>" required>
        </div>

        <div class="form-group">
            <label for="credits">Credits</label>
            <input type="number" class="form-control" id="credits" name="credits" value="<?php echo htmlspecialchars($class['credits']); ?>" required>
        </div>

        <div class="form-group">
            <label for="max_capacity">Max Capacity</label>
            <input type="number" class="form-control" id="max_capacity" name="max_capacity" value="<?php echo htmlspecialchars($class['max_capacity']); ?>" required>
        </div>

        <div class="form-group">
            <label for="availability_datetime">Availability Start</label>
            <input type="datetime-local" class="form-control" id="availability_datetime" name="availability_datetime" value="<?php echo str_replace(' ', 'T', htmlspecialchars($class['availability_datetime'])); ?>" required>
        </div>

        <div class="form-group">
            <label for="availability_end_datetime">Availability End</label>
            <input type="datetime-local" class="form-control" id="availability_end_datetime" name="availability_dateendtime" value="<?php echo str_replace(' ', 'T', htmlspecialchars($class['availability_dateendtime'])); ?>" required>
        </div>

        <div class="form-group">
            <label for="study_programme">Study Programme</label>
            <select class="form-control" id="study_programme" name="study_programme" required>
                <option value="" disabled>Select Programme</option>
                <?php
                $programmes = ["NHF", "FPM", "OF", "FMV", "Selective Class"];
                foreach ($programmes as $programme) {
                    $selected = ($class['study_programme'] == $programme) ? 'selected' : '';
                    echo "<option value='$programme' $selected>$programme</option>";
                }
                ?>
            </select>
        </div>
        <a href="adminDashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        <button type="submit" class="btn btn-primary">Update Class</button>
    </form>
</div>
</body>
</html>
