<!DOCTYPE html>
<html>
    <head>
        <title>Leaderboard</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="./index.html">Back to homepage</a>
        <h1>Leaderboard</h1>
        <?php
            // database connection parameters
            $servername = "dbd-leaderboard.c7sicgqg6s25.us-west-1.rds.amazonaws.com";
            $username = "admin";
            $password = "ducksbathdefense";
            $db = "leaderboard";

            function addRow($name, $score, $date) {
                // generates a table row with given values
                echo "<tr><td>$name</td><td>$score</td><td>$date</td></tr>";
            }
                
            try {
                // Create a PDO connection
                $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
                // Set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                // Query to select high scores from the database
                $sql = "SELECT name, score, date FROM Entry ORDER BY score DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "<table>";
                addRow("Name", "Score", "Date");

                // Display data in a table
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    addRow($row["name"], $row["score"], $row["date"]);
                }

                echo "</table>";
                
            } catch(PDOException $e) {
                echo "<h2>Error: " . $e->getMessage() . "</h2>";
            }

            // Close connection
            $conn = null;
        ?>
    </body>
</html>
