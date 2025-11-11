
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <a href="logout.php" class="btn btn-primary w-100 mb-4">Logout</a>
                    <a href="SeeStudents.php" class="btn btn-secondary w-100 mb-4">See Students</a>
                    <a href="AddClasses.php" class="btn btn-secondary w-100 mb-4">Add Classes</a>
                    <a href="ManageAllClasses.php" class="btn btn-secondary w-100 mb-4">Manage Classes</a>
                    <a href="ExcelExportTable.php" class="btn btn-secondary w-100 mb-4">Excel table</a>
                   
                    
                </div>
            </div>
            <div class="col-md-9">
                <?php
                require 'database.php'; 

                // SQL queries to fetch analytics data
                $studentsQuery = "SELECT COUNT(*) AS total_students FROM users";
                $classesQuery = "SELECT COUNT(*) AS total_classes FROM classes";
                $enrollmentsQuery = "SELECT COUNT(*) AS total_enrollments FROM enrollments";

                // Execute queries and fetch results
                $totalStudents = $conn->query($studentsQuery)->fetch_assoc()['total_students'];
                $totalClasses = $conn->query($classesQuery)->fetch_assoc()['total_classes'];
                $totalEnrollments = $conn->query($enrollmentsQuery)->fetch_assoc()['total_enrollments'];
                ?>

                <div class="analytics">
                    <h2>Analytics</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-header">Total Students</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $totalStudents; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header">Total Classes</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $totalClasses; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-header">Total Enrollments</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $totalEnrollments; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
