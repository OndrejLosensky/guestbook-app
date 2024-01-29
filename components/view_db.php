<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewed database</title>
    <link rel="stylesheet" href="/GuestBook_GITHUB/styles/ViewDb.css">
    <style>
         li {
            position: relative;
        }

        form {
            position: absolute;
            top: 25%;
            right: 0.75%;
        }

        input[type="submit"] {
            background-color:transparent;
            border: 1px solid red;
            border-radius: 15px;
            color:red;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
        }

        .entry-date {
            font-size: 12px;
            color: #888;
            position: absolute;
            top:35%;
            right:5%;
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

        .button-link-delete {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            background-color: #ff0000;
            color: #fff;
            padding: 10px 15px; 
            border-radius: 5px;
        }

        .button-icon {
            width: 20px;
            height: 20px; 
            margin-right: 10px; 
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            opacity: 1;
            padding: 5px;
            margin: 0;
            padding-left: 16px;
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
            background-size: 30px 30px;
            opacity: 0.45;
            pointer-events: none;
            z-index: -1; 
        }

        .header {
            position:absolute;
            left: 0;
            top:0;
            background-color: #007bff;
            color: white;
            height:60px;
            width: 100%;
            text-align: center;
        }
        

        h4 {
            font-size:16px;
            font-weight: 500;
        }

        h1 {
            padding-top:40px;
        }

        span {
            font-weight:800;
        }

    </style>
</head>
<body>
    <div class="header">
           <h4> Welcome, {user_id} </h4> 
    </div>
    <h1> 
        Database with comments
    </h1>
    <p> This database has <span><?php echo getCommentCount(); ?></span> comments now </p>
    <p>
        <a href="../index.html" class="button-link">
            <img src="/GuestBook_GITHUB/assets/arrowIcon.png" alt="Icon" class="button-icon">
            Back to login
        </a>
        <a  class="button-link">
            <img src="/GuestBook_GITHUB/assets/logIcon.png" alt="Icon" class="button-icon">
            Logs
        </a>
        <a href="../homepage.html"  class="button-link">
            <img src="/GuestBook_GITHUB/assets/sendIcon.png" alt="Icon" class="button-icon">
            Insert comment
        </a>
        <a href="../generate_data/InsertLoop.html"  class="button-link">
            <img src="/GuestBook_GITHUB/assets/generateIcon.png" alt="Icon" class="button-icon">
            Generate data
        </a>
        <a href="#" id="deleteAllRows" class="button-link-delete">
            <img src="/GuestBook_GITHUB/assets/deleteIcon.png" alt="Icon" class="button-icon">
            Delete all records
        </a>
    </p>

    
    <?php
    // function that comments how many comments are there
        function getCommentCount() {
            $mydb = new mysqli("localhost", "root");
            $mydb->select_db("guestbook_db");

            $select = "SELECT COUNT(*) as count FROM guestbook_entrie";
            $result = $mydb->query($select);

            if ($result) {
                $row = $result->fetch_assoc();
                return $row['count'];
            } else {
                return 0;
            }
        }

        // Db connection
        $mydb = new mysqli("localhost","root");
        $mydb->select_db("guestbook_db");

        // checking if the connection is okey
        if ($mydb->connect_error) {
            die("Connection failed: " . $mydb->connect_error);
        }

        if (isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];
            $command_delete = "DELETE FROM guestbook_entrie WHERE id = $delete_id";

            if ($mydb->query($command_delete) === TRUE) {
                echo "Entry $delete_id was successfully deleted!";

                // echo "<script>setTimeout(function() { location.reload(); }, 1000);</script>";
            } else {
                echo "Ooops, there was an error: " . $mydb->error;
            }
        }

        $command_select = "SELECT * FROM guestbook_entrie ORDER BY entry_date DESC";
        $result = $mydb->query($command_select);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>
                            <strong>" . $row["name"] . ":</strong> " . $row["message"] . "
                            <span class='entry-date'>" . $row["entry_date"] . "</span>
                            <form action='view_db.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete'>
                            </form>
                        </li>";
                }
                echo "</ul>";
            } else {
                echo "<p> I haven't found any comments in the database. Try creating one</p>";
            }
        } else {
            echo "Error executing query: " . $mydb->error;
        }

        // closes the connection with the database
        $mydb->close();
    ?>

    <script>
            document.getElementById('deleteAllRows').addEventListener('click', function(e) {
            e.preventDefault();

            fetch('delete_all.php', {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Response from delete.php:', data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    </script>

   
</body>
</html>
