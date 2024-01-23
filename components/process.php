<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>process comments</title>
</head>
<body>
<?php

    // Process the form submission
    $name = $_POST["name"];
    $message = $_POST["message"]; 

    // Database connection details
    $mydb = new mysqli("localhost","root");
    $mydb->select_db("guestbook_db");

    // Insert guestbook entry into the database
    $command_insert = "INSERT INTO guestbook_entrie (name, message) VALUES ('$name', '$message')";
    $mydb->query($command_insert);

    // Close connection
    $mydb->close();

    // Redirect back to the guestbook form page
    header("Location: /GuestBook_GITHUB/index.html");
    exit();

?>
</body>
</html>
