<?php

if (isset($_POST["submit"])) {
    require_once "database.php"; 

    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeat_password"];
    $school = $_POST["school"];
    $errors = array();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($fullName) || empty($email) || empty($password) || empty($repeatPassword) || empty($school)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 6) {
        array_push($errors, "Password must be at least 6 characters long");
    }
    if ($password !== $repeatPassword) {
        array_push($errors, "The two passwords do not match");
    }
    
   
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL error");
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            array_push($errors, "Email already exists!");
        }
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "INSERT INTO users(full_name, email, password, school) VALUES(?, ?, ?, ?)";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $fullName, $email, $passwordHash, $school);
            mysqli_stmt_execute($stmt);
            $_SESSION['success_message'] = "You are registered successfully."; 
            header('Location: registration.php'); // Redirect 
            exit();
        } else {
            die("Something went wrong.");
        }
    }
}

?>