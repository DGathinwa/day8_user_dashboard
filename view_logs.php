<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT logs.*, users.fullname FROM logs JOIN users ON logs.user_id = users.id ORDER BY logs.timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Activity Logs</title>
</head>
<body>
    <h2>Activity Logs</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>

        <?php while ($log = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['fullname']); ?></td>
                <td><?php echo htmlspecialchars($log['action']); ?></td>
                <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="admin_panel.php">⬅ Back to Admin Panel</a></p>
</body>
</html>
