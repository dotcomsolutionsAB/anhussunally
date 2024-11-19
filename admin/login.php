<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim the input to remove any extra spaces
    $id = trim($_POST['id']);
    $password = trim($_POST['password']);

    // Static credentials
    $staticId = "Shaqlin@89005";
    $staticPassword = "Shaqlin@8905";

    if ($id === $staticId && $password === $staticPassword) {
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid ID or Password.";
    }
}
?>


