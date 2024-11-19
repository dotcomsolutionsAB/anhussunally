<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim the input to remove any extra spaces
    $id = trim($_POST['id']);
    $password = trim($_POST['password']);

    // Static credentials
    $staticId = "Shaqlin@8905";
    $staticPassword = "Shaqlin@8905";

    if ($id === $staticId && $password === $staticPassword) {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $id; // Store the ID in the session
        header('Location: dashboard.php'); // Redirect to the dashboard
        exit;
    } else {
        $_SESSION['error'] = "Invalid ID or Password.";
        header('Location: index.php'); // Redirect back to the login page
        exit;
    }
}
?>
