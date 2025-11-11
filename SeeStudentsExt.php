<?php
        require 'database.php'; 

        $search = isset($_GET['search']) ? "%{$_GET['search']}%" : null;

        if ($search) {
            $sql = "SELECT id, full_name, email, school FROM users WHERE full_name LIKE ? OR email LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $search, $search);
        } else {
            $sql = "SELECT id, full_name, email, school FROM users";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='table table-hover center-table'><thead class='thead-dark'><tr><th>ID</th><th>Full Name</th><th>Email</th><th>School</th></tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td><a href='StudentClasses.php?student_id=".$row["id"]."'>".$row["full_name"]."</a></td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["school"]."</td>";
                echo "</tr>";
            }
            

            echo "</tbody></table>";
        } else {
            echo "0 results found";
        }

        $conn->close();
        ?>