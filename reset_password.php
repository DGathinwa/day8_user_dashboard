<?php
require 'config.php';

$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and hasn't expired
    $sql = "SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = '$new_password', reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = '$token'";
            if ($conn->query($update_sql)) {
                $message = "✅ Your password has been reset successfully. <a href='login.php'>Login here</a>";
            } else {
                $message = "❌ Failed to reset password. Please try again.";
            }
        }
    } else {
        $message = "❌ Invalid or expired token.";
    }
} else {
    $message = "❌ No token provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <?php if (isset($_GET['token']) && $result->num_rows === 1): ?>
        <form method="POST">
            <label>New Password:</label><br>
            <input type="password" name="new_password" required><br><br>
            <button type="submit">Reset Password</button>
        </form>
    <?php endif; ?>
</body>
</html>
