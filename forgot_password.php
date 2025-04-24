<?php
session_start();
require 'config.php';

$message = "";

// Handle forgot password form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour')); // Set token expiry time (1 hour)

        // Save token to the database
        $conn->query("UPDATE users SET reset_token = '$token', reset_token_expiry = '$expiry_time' WHERE email = '$email'");

        // Send the password reset email with the link
        $resetLink = "http://localhost/day8_user_dashboard/reset_password.php?token=$token";
        mail($email, "Password Reset Request", "Click the link to reset your password: $resetLink");

        $message = "✅ An email has been sent with instructions to reset your password.";
    } else {
        $message = "❌ No user found with that email address.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit">Send Password Reset Link</button>
    </form>

    <p>Remember your password? <a href="login.php">Login here</a>.</p>
</body>
</html>
