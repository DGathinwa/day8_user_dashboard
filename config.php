<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "day8_user_dashboard";  // Change this to match the database you created

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
