<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> DELETE ALL records</title>
</head>
<body>
    <h1> DELETE all records</h1>
    <?php
        $mydb = new mysqli("localhost", "root");
        $mydb->select_db("guestbook_db");

        // checks the connection to the DB
        if ($mydb->connect_error) {
            die("Connection failed: " . $mydb->connect_error);
        }

        $delete="DELETE FROM guestbook_entrie";
        $result = $mydb->query($delete);

        echo "All rows were deleted successfully!";

        // Close connection
        $mydb->close();

        // Redirect back to the guestbook form page
        header("Location: /GuestBook_GITHUB/view_db.php");
        exit();
    ?>
</body>
</html>