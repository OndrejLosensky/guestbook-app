<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $auth_db = new mysqli("localhost", "root", "", "guestbook_db");

    // Check connection
    if ($auth_db->connect_error) {
        die("Connection failed: " . $auth_db->connect_error);
    }

    // Get user input
    $username = $_POST["name"];
    $password = $_POST["password"];

    // Retrieve user data from the database
    $select_user = $auth_db->prepare("SELECT id, name, password, role FROM users WHERE name = ?");
    $select_user->bind_param("s", $username);
    $select_user->execute();
    $result = $select_user->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user_data["password"])) {
            // Authentication successful
            $_SESSION["user_id"] = $user_data["id"];
            $_SESSION["name"] = $user_data["name"];
            $_SESSION["role"] = $user_data["role"];

            // Check if the user is an admin
            if ($_SESSION["role"] === "admin") {
                // admin login
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                // Regular user login
                header("Location: ../components/view_db.php");
                exit();
            }
        } else {
            // Authentication failed
            echo "Invalid username or password.";
        }
    } else {
        // User not found
        echo "Invalid username or password.";
    }

    // Close connections
    $select_user->close();
    $auth_db->close();
}
       
?>
