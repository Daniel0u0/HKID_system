<?php
// File: dashboard.php
// Role-based dashboard
session_start();
require 'config.php';

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header("Location: index.php");
    exit;
}

// RBAC: Define allowed actions per role
$rolePermissions = [
    'citizen' => ['book_appointment'],
    'junior_staff' => ['view_appointments'],
    'approving_staff' => ['view_appointments', 'approve_appointment'],
    'admin' => ['view_appointments', 'approve_appointment', 'manage_users']
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && in_array('book_appointment', $rolePermissions[$_SESSION['role']])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $hkid = filter_var($_POST['hkid'], FILTER_SANITIZE_STRING);
    $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($hkid) || empty($dob) || empty($date)) {
        $error = "All fields are required.";
    } elseif (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $hkid)) {
        $error = "Invalid HKID format.";
    } else {
        // Insert appointment with prepared statement
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, name, hkid, dob, appointment_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name, $hkid, $dob, $date]);
        logActivity("Appointment booked by user ID {$_SESSION['user_id']}");
        $success = "Appointment booked successfully.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HKID Appointment System - Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['role']); ?></h2>
    <?php if (isset($error)) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green'>" . htmlspecialchars($success) . "</p>"; ?>

    <?php if (in_array('book_appointment', $rolePermissions[$_SESSION['role']])): ?>
        <h3>Book Appointment</h3>
        <form method="POST" action="">
            <label>Name:</label>
            <input type="text" name="name" required><br><br>
            <label>HKID:</label>
            <input type="text" name="hkid" required><br><br>
            <label>Date of Birth:</label>
            <input type="date" name="dob" required><br><br>
            <label>Appointment Date:</label>
            <input type="datetime-local" name="date" required><br><br>
            <input type="submit" value="Book">
        </form>
    <?php endif; ?>

    <?php if (in_array('view_appointments', $rolePermissions[$_SESSION['role']])): ?>
        <h3>View Appointments</h3>
        <?php
        $stmt = $pdo->prepare("SELECT id, name, hkid, dob, appointment_date FROM appointments");
        $stmt->execute();
        $appointments = $stmt->fetchAll();
        foreach ($appointments as $appt) {
            echo "<p>" . htmlspecialchars($appt['name']) . " | " . htmlspecialchars($appt['hkid']) . " | " . htmlspecialchars($appt['appointment_date']) . "</p>";
        }
        ?>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</body>
</html>