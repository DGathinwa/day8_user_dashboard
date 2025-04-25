<?php
session_start();

// Only allow admin access
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>👑 Admin Panel</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</p>
    <p>You have administrative privileges.</p>

    <ul>
        <li><a href="manage_users.php">👥 Manage Users</a></li>
        <li><a href="site_settings.php">⚙️ Site Settings</a></li>
        <li><a href="dashboard.php">⬅️ Back to Dashboard</a></li>
    </ul>
</body>
</html>
