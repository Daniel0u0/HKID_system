<?php
// File: index.php
// Login page with MFA simulation
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Check credentials
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['mfa_code'] = rand(100000, 999999); // Simulate MFA code
            logActivity("Successful login attempt for $username");
            header("Location: mfa.php");
            exit;
        } else {
            $error = "Invalid credentials.";
            logActivity("Failed login attempt for $username");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HKID Appointment System - Login</title>
</head>
<body>
    <h2>HKID Appointment System Login</h2>
    <?php if (isset($error)) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
