<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION["user"];
$sql = "SELECT * FROM users WHERE fullname = '$user'";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    echo "❌ User not found.";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body { font-family: Arial; margin: 2rem; }
        input { display: block; margin: 10px 0; padding: 8px; width: 300px; }
        .btn { padding: 8px 15px; background: green; color: white; border: none; cursor: pointer; }
        .danger { background: red; }
    </style>
</head>
<body>
    <h2>👤 Your Profile</h2>
    <form action="update_profile.php" method="post">
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($row['fullname']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>

        <label>New Password (leave blank to keep current):</label>
        <input type="password" name="password">

        <button class="btn" type="submit">Update Profile</button>
    </form>

    <form action="delete_account.php" method="post" onsubmit="return confirm('⚠️ Are you sure you want to delete your account?');">
        <button class="btn danger" type="submit">Delete Account</button>
    </form>

    <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
</body>
</html>
