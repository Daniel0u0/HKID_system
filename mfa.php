<?php
// File: mfa.php
// MFA verification page
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = filter_var($_POST['code'], FILTER_SANITIZE_NUMBER_INT);
    if ($code == $_SESSION['mfa_code']) {
        $_SESSION['authenticated'] = true;
        logActivity("MFA verified for user ID {$_SESSION['user_id']}");
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid MFA code.";
        logActivity("Failed MFA attempt for user ID {$_SESSION['user_id']}");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HKID Appointment System - MFA</title>
</head>
<body>
    <h2>Enter MFA Code</h2>
    <p>Code: <?php echo htmlspecialchars($_SESSION['mfa_code']); ?> (In a real system, this would be sent via SMS/email)</p>
    <?php if (isset($error)) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="POST" action="">
        <label>MFA Code:</label>
        <input type="text" name="code" required><br><br>
        <input type="submit" value="Verify">
    </form>
</body>
</html>
