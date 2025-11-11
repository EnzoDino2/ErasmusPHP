<?php
session_start(); // Start the session.

// Check if user is logged in and if they are an admin.
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
    <title>Add Classes</title>
</head>
<body>
    <div class="container my-5">
    <h1>Add a class to the database</h1>
    <?php
    if (isset($_POST["submit"])) {
        require_once "database.php"; //database connection file

        $class_name = $_POST["class_name"];
    $id_code = $_POST["id_code"];
    $credits = $_POST["credits"];
    $max_capacity = $_POST["max_capacity"];
    $availability_datetime = $_POST["availability_datetime"];
    $availability_dateendtime = $_POST["availability_dateendtime"];
    $study_programme = $_POST["study_programme"];

    if (empty($class_name) || empty($id_code) || empty($credits) || empty($max_capacity) || empty($availability_datetime) || empty($availability_dateendtime) || empty($study_programme)) {
        echo "<p>Please fill in all fields correctly.</p>";
    } else {
        $sql = "INSERT INTO classes (class_name, id_code, credits, max_capacity, availability_datetime, availability_dateendtime, study_programme) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiisss", $class_name, $id_code, $credits, $max_capacity, $availability_datetime, $availability_dateendtime, $study_programme);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Class added successfully!</p>";
        } else {
            echo "<p>Error adding class: " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
    ?>

    <form action="AddClasses.php" method="post">
        <div class="form-group">
            <label for="class_name">Class Name:</label>
            <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Class name" required>
        </div>
        <div class="form-group">
            <label for="id_code">ID Code:</label>
            <input type="text" class="form-control" id="id_code" name="id_code" placeholder="ID code" required>
        </div>
        <div class="form-group">
            <label for="credits">Credits:</label>
            <input type="number" class="form-control" id="credits" name="credits" placeholder="Credits" required>
        </div>
        <div class="form-group">
            <label for="max_capacity">Max Capacity:</label>
            <input type="number" class="form-control" id="max_capacity" name="max_capacity" placeholder="Max capacity" required>
        </div>
        <div class="form-group">
            <label for="availability_datetime">Availability Date Time:</label>
            <input type="datetime-local" class="form-control" id="availability_datetime" name="availability_datetime" required>
        </div>
        <div class="form-group">
            <label for="availability_dateendtime">Availability Date End Time:</label>
            <input type="datetime-local" class="form-control" id="availability_dateendtime" name="availability_dateendtime" required>
        </div>
        <div class="form-group">
    <label for="study_programme">Study Programme:</label>
    <select class="form-control" id="study_programme" name="study_programme" required>
        <option value="NHF">NHF</option>
        <option value="FPM">FPM</option>
        <option value="OF">OF</option>
        <option value="FMV">FMV</option>
        <option value="Selective Class">Selective Class</option>
        <option value="Not Defined">Not Defined</option>
    </select>
</div>
        
        <a href="adminDashboard.php" class="btn btn-secondary">Back to Dashboard</a>

        <button type="submit" class="btn btn-primary" name="submit">Add Class</button>
    </form>
    </div>
</body>
</html>
