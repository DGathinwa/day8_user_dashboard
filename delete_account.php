<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Clear session
    session_destroy();
    header("Location: login.php?msg=Account+Deleted");
    exit();
} else {
    echo "❌ Error deleting account: " . $conn->error;
}
?>
