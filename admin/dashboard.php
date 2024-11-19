<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard!  <?php echo $_SESSION['id'] ?></h2>
    <p>You are successfully logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
