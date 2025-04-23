<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $conn->real_escape_string($_POST["fullname"]);
    $email = $conn->real_escape_string($_POST["email"]);

    $sql = "UPDATE users SET fullname='$fullname', email='$email' WHERE id=$user_id";

    if ($conn->query($sql)) {
        echo "✅ Profile updated successfully.";
        // Optionally update session name
        $_SESSION["user"] = $fullname;
    } else {
        echo "❌ Error updating profile: " . $conn->error;
    }
}

// Fetch current data
$result = $conn->query("SELECT fullname, email FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
</body>
</html>
