<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2>Your classes:</h2>
    <div class="row">
        <?php
        
        include("SeeClassesExt.php");
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row["class_name"]) . '</h5>';
            echo '<p class="card-text">ID Code: ' . htmlspecialchars($row["id_code"]) . '</p>';
            echo '<p class="card-text">Credits: ' . htmlspecialchars($row["credits"]) . '</p>';
            echo '<p class="card-text">Capacity: '. htmlspecialchars($row["max_capacity"]) . '</p>';
            echo '<form action="DropClasses.php" method="post">';
            echo '<input type="hidden" name="enrollment_id" value="' . $row["enrollment_id"] . '">';
            echo '<button type="submit" class="btn btn-danger">Drop</button>';
            echo '</form>'; 
            echo '</div>'; 
            echo '</div>'; 
            echo '</div>'; 
        }
        ?>
    </div> 
    <div class="mt-3">
        <a href="ClassesSelect.php" class="btn btn-primary">Select More Classes</a>
    </div>
</div> 
</body>
</html>
