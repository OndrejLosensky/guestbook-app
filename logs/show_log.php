<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display logs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ddd;
        }
        .button-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px; 
            border-radius: 5px;
        }

        .button-icon {
            width: 20px;
            height: 20px; 
            margin-right: 10px; 
        }

    </style>
</head>
<body>
    <h1>History of logs</h1>
    <a href="../components/view_db.php" class="button-link">
            <img src="/GuestBook_GITHUB/assets/arrowIcon.png" alt="Icon" class="button-icon">
            Back to homepage
        </a>
    <?php
        session_start();

        
        // Db connection
        $mydb = new mysqli("localhost","root");
        $mydb->select_db("guestbook_db");

        $select_command = "SELECT * FROM login_logs ORDER BY timestamp DESC";
        $result = $mydb->query($select_command);

        // Check if there are any logs
        if ($result->num_rows > 0) {
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