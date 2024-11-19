<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Display the ID
$loggedInId = "Shaqlin@8905"; // Since we're using static credentials
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard!</h2>
    <p>You are successfully logged in as: <strong><?php echo $loggedInId; ?></strong></p>
    <a href="logout.php">Logout</a>
</body>
</html>
