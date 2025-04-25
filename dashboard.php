<?php
session_start();
require 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Retrieve user info
$user_id = $_SESSION["user_id"];
$sql = "SELECT fullname, email, role FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Role from session
$role = $_SESSION["user_role"] ?? 'unknown';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>

    <?php if ($role === 'admin'): ?>
        <p style="color:green;"><strong>✅ Admin Privileges Granted</strong></p>
        <a href="admin_panel.php">Go to Admin Panel</a><br>
    <?php endif; ?>

    <a href="update_profile.php">Edit Profile</a> | 
    <a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
