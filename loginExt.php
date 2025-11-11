<?php
    if (isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "database.php";
        $sql= "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            if(password_verify($password,$user["password"])){
                session_start();
                $_SESSION["user_id"] = $user["id"];
                header("Location: ClassesSelect.php");
                die();
            }else{
                echo "<div class='alert alert-danger'>Wrong password</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>Email does not exist</div>";
        }
    }
    ?>