<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION["user"];

// Find user ID
$userQuery = $conn->query("SELECT id FROM users WHERE fullname = '$current_user'");
if ($userQuery->num_rows !== 1) {
    echo "❌ Error: User not found.";
    exit();
}

$userId = $userQuery->fetch_assoc()["id"];

// Delete the user
$delete = $conn->query("DELETE FROM users WHERE id = $userId");

if ($delete) {
    session_destroy();
    echo "🧹 Your account has been deleted. <a href='register.php'>Register again</a> or <a href='login.php'>Login</a>.";
} else {
    echo "❌ Failed to delete account. Please try again.";
}

$conn->close();
?>
