<?php
// File: logout.php
// Logout functionality
session_start();
session_destroy();
logActivity("User logged out");
header("Location: index.php");
exit;
?>