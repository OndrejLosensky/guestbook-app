<?php
    session_start();

    // Connect to the database
    $auth_db = new mysqli("localhost", "root", "", "guestbook_db");

    // Check connection
    if ($auth_db->connect_error) {
        die("Connection failed: " . $auth_db->connect_error);
    }

    // Get user input
    $username = $_POST["name"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insert user into the database
    $register = $auth_db->prepare("INSERT INTO users (name, password) VALUES (?, ?)");

    // Check if the prepare and bind were successful
    if ($register === false) {
        die("Error in prepare: " . $auth_db->error);
    }

    $register->bind_param("ss", $username, $password);

    if ($register->execute()) {
        echo "Registration successful. <a href='/GuestBook_GITHUB/login/login.html'>Login here</a>.";

    } else {
        echo "Error: " . $register->error;
    }

    // Close connections
    $register->close();
    $auth_db->close();

?>