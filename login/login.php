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
    $select_user = $auth_db->prepare("SELECT id, name, password FROM users WHERE name = ?");
    $select_user->bind_param("s", $username);
    $select_user->execute();
    $result = $select_user->get_result();

    // logs the data to another table
    function logLogin($username, $status) {
        $mydb = new mysqli("localhost", "root");
        $mydb->select_db("guestbook_db");

        if ($mydb->connect_error) {
            die("Connection failed: " . $mydb->connect_error);
        }
    
        $query = "INSERT INTO login_logs (name, status) VALUES ('$username', '$status')";
        
        if ($mydb->query($query) === TRUE) {
            echo "Login logged successfully";
        } else {
            echo "Error: " . $query . "<br>" . $mydb->error;
        }
    
        $mydb->close();
    }


    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user_data["password"])) {
            // Authentication successful
            $_SESSION["user_id"] = $user_data["id"];
            $_SESSION["name"] = $user_data["name"];
            logLogin($user_data["name"], 'Success');
            header("Location: ../components/view_db.php");
            exit();
        } else {
            // Authentication failed
            logLogin($username, 'Failure');
            echo "Invalid username or password.";
        }
    } else {
        // User not found
        logLogin($username, 'Failure');
        echo "Invalid username or password.";
    }

    // Close the connection
    $select_user->close();
    $auth_db->close();
}
       
?>
