<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration successful</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .success-message {
            color: green;
            font-weight: bold;
            font-size: 32px;
            text-align: center;
        }

        .login-link {
            color: blue;
            text-decoration: none;
            font-size:20px;
            font-weight:400;
            background-color: #007bff; 
            border-radius:8px;
            padding: 10px 10px 20px 20px;
            color:white;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
    session_start();

    // Connect to the database
    $auth_db = new mysqli("localhost", "root", "", "guestbook_db");

    // Check connection
    if ($auth_db->connect_error) {
        die("Connection failed: " . $auth_db->connect_error);
    }

    $password = $_POST["password"];

    // Validate password length
    if (strlen($password) < 8) {
        echo "password is too short!";

    } 
    else {
        // Get user input
        $username = $_POST["name"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];

        // Insert user into the database
        $register = $auth_db->prepare("INSERT INTO users (name,email,password) VALUES (?, ?, ?)");

        // Check if the prepare and bind were successful
        if ($register === false) {
            die("Error in prepare: " . $auth_db->error);
        }

        $register->bind_param("sss", $username,$email, $password);

        if ($register->execute()) {
            echo "<p class='success-message'>Registration successful. <br> <a href='../index.html' class='login-link'>Login here</a>.</p>";

        } else {
            echo "Error: " . $register->error;
        }
    }

   

    // Close connections
    $register->close();
    $auth_db->close();

?>
</body>
</html>
