<?php
session_start(); // Start the session

error_reporting(E_ALL);
ini_set('display_errors', 1); 
// Database configuration
$host = 'localhost';
$dbname = 'anhuszzw_html';
$username = 'anhuszzw_html';
$password = '9kCuzrb5tO53$xQtf';

// Establish connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $_SESSION['message'] = "Database connection failed: " . $conn->connect_error;
    $_SESSION['message_type'] = "error";
    header("Location: contact.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO mail (user_name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Set flash message for success
        $_SESSION['message'] = "Message sent successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        // Set flash message for error
        $_SESSION['message'] = "Database error: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }

    // Redirect back to the contact page
    header("Location: contact.php");
    exit;
} else {
    $_SESSION['message'] = "Invalid request method";
    $_SESSION['message_type'] = "error";
    header("Location: contact.php");
    exit;
}

$conn->close();
?>