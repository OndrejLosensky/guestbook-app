<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Proccess the generated data!</title>
</head>
<body>
    <h1>Your data was generated</h1>
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

    <a href="/GuestBook_GITHUB/index.html"> Back to main page</a>

</body>
</html>