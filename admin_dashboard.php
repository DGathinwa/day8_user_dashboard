<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>🛡️ Welcome to the Admin Panel, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>
    <a href="dashboard.php">User Dashboard</a> |
    <a href="logout.php">Logout</a>
</body>
</html>
