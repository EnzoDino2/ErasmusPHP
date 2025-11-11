<?php
session_start();
require_once "database.php"; 


include "GetClasses.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Sign-Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
    <link rel="stylesheet" href="AddClassesStyle.css">
    <script>
        function checkLimit(element) {
            let checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            let nAllowedClasses = 5;
            if (checkedCheckboxes.length > nAllowedClasses) {
                alert("You can select up to " + nAllowedClasses + " classes only.");
                element.checked = false;
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Select classes to sign up for (up to 5)</h2>
        
        <form method="POST" action="ClassesSelectExt.php">
            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row["class_name"]); ?></h5>
                                    <p class="card-text">Credits: <?php echo htmlspecialchars($row["credits"]); ?></p>
                                    <p class="card-text">Capacity: <?php echo htmlspecialchars($row["max_capacity"]); ?></p>
                                    <p class="card-text">ID Code: <?php echo htmlspecialchars($row["id_code"]); ?></p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_ids[]" value="<?php echo htmlspecialchars($row["class_id"]); ?>" onclick="checkLimit(this);">
                                        <label class="form-check-label" for="class<?php echo htmlspecialchars($row["class_id"]); ?>">Select</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No classes are currently available for enrollment.</p>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Sign Up</button>
        </form>
        <a href="SeeClasses.php" class="btn btn-secondary mt-3">See Your Classes</a>
        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
        <!-- Messages will be displayed after redirection from ClassesSelectExt.php -->
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="row">
                <div class="col-12">
                    <?php foreach ($_SESSION['messages'] as $message): ?>
                        <div class="alert <?php echo $message['type'] === 'error' ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                            <?php echo htmlspecialchars($message['text']); ?>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['messages']); // Clear messages after displaying ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
