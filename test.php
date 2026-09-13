<?php
require "config/database.php";
$result = mysqli_query($conn, "SHOW TABLES");
echo "<h2>Database Connection Test Successful!</h2>";
echo "<p>Existing tables:</p><ul>";
while ($row = mysqli_fetch_array($result)) {
    echo "<li>" . $row[0] . "</li>";
}
echo "</ul>";
?>