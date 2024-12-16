<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

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
} else {
    // Redirect to login page if accessed without POST
    header('Location: index.php');
    exit;
}
?>
