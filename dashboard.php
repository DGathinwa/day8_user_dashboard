<?php
session_start();
require 'config.php';

// Redirect to login if user not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION["user_id"];
$sql = "SELECT fullname, email FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <a href="update_profile.php">Edit Profile</a> | 
    <a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
