<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Trim the input to remove any extra spaces
        $id = trim($_POST['id']);
        $password = trim($_POST['password']);

        // Updated static credentials
        $staticId = "Shaqlin@8905"; // Corrected ID
        $staticPassword = "Shaqlin@8905"; // Corrected Password

        if ($id === $staticId && $password === $staticPassword) {
            $_SESSION['loggedin'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Invalid ID or Password.";
        }
    }
?>


