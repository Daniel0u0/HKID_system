<?php
// File: config.php
// Database and configuration settings
define('DB_HOST', 'localhost');
define('DB_USER', 'hkid_user'); // Use a limited-privilege user
define('DB_PASS', 'secure_password'); // Replace with strong password
define('DB_NAME', 'hkid_appointments');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . htmlspecialchars($e->getMessage()));
}

// Logging function
function logActivity($message) {
    $logFile = 'logs/security.log';
    $timestamp = date('Y-m-d H:');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}
?>