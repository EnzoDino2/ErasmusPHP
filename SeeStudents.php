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
    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -50px;
        }
        .center-table {
            margin: 0 auto;
            width: 80%;
            max-width: 600px;
        }
    </style>
    <title>Student Table with Search</title>
</head>
<body>
<div class="container mt-5">
    <div class="search-container mb-4">
        <form action="" method="GET">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Search by name or email">
                <button type="submit" class="btn btn-primary mt-2">Search</button>
            </div>
            <a href="adminDashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>

    <div class="table-container">
        <?php
      include("SeeStudentsExt.php");
      ?>
    </div>
</div>
</body>
</html>
