<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display logs</title>
</head>
<body>
    <h1>History of logs</h1>
    <?php
        session_start();

        
        // Db connection
        $mydb = new mysqli("localhost","root");
        $mydb->select_db("guestbook_db");

        $select_command = "SELECT * FROM login_logs ORDER BY timestamp DESC";
        $result = $mydb->query($select_command);

        // Check if there are any logs
        if ($result->num_rows > 0) {
            echo "<h2>Login Logs</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Username</th><th>Status</th><th>Timestamp</th></tr>";

            // Fetch and display each log
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No login logs found.";
        }

        // Closes the connection with the db
        $mydb->close();

    ?>
</body>
</html>