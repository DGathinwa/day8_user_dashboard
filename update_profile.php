<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $conn->real_escape_string($_POST["fullname"]);
    $email = $conn->real_escape_string($_POST["email"]);

    $sql = "UPDATE users SET fullname=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fullname, $email, $user_id);

    if ($stmt->execute()) {
        $_SESSION["user_name"] = $fullname; // update session
        logAction($user_id, "Updated profile");
        echo "✅ Profile updated successfully.";
    } else {
        echo "❌ Error updating profile: " . $conn->error;
    }
}

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
        <label>Full Name:</label><br>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
</body>
</html>
