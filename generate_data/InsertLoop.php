<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Proccess the generated data!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            opacity: 1;
            padding: 20px;
            margin: 0;
            padding-left: 20px;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(0, 0, 0, 0.15) 1px, transparent 2px);
            background-size: 35px 35px;
            opacity: 0.65;
            pointer-events: none;
            z-index: -1; 
        }

        h1 {
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

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

    </style>
</head>
<body>
    <h1>Your data was generated</h1>

    <a href="../components/view_db.php" class="button-link">
            <img src="/GuestBook_GITHUB/assets/arrowIcon.png" alt="Icon" class="button-icon">
            Back to main page
    </a>

    <p>
        <?php
            $mydb = new mysqli("localhost", "root");
            $mydb->select_db("guestbook_db");

            // checks the connection to the DB
            if ($mydb->connect_error) {
                die("Connection failed: " . $mydb->connect_error);
            }
            
            // the loop creates 50 records
            for ($i = 1; $i <= 50; $i++) {
                $name= "Name" . $i;
                $message= "This is generated text no." . $i;
            
                $command_insert = "INSERT INTO guestbook_entrie (name, message) VALUES ('$name','$message')";
                $mydb->query($command_insert);
            }
            
            echo "I have successfully generated 50 records!";

            $select="SELECT * FROM guestbook_entrie";
            $result = $mydb->query($select);

            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Name</th><th>Message</th><th>Time created</th></tr>";
            
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['entry_date'] . "</td>";
                    echo "</tr>";
                }
            
                echo "</table>";
            } else {
                echo "I haven't found any records";
            }
            
            // closes the connection with DB
            $mydb->close();

        ?>
    </p>

</body>
</html>