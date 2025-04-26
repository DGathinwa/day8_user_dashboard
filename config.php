<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "day8_user_dashboard"; // Match your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logging Function
function logAction($user_id, $action) {
    global $conn;
    $user_id = (int)$user_id;
    $action = $conn->real_escape_string($action);

    $sql = "INSERT INTO logs (user_id, action) VALUES ($user_id, '$action')";
    $conn->query($sql);
}
?>
