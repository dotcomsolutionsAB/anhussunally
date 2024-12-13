<?php
header('Content-Type: application/json'); // Ensure the correct content type
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1); 
// Database configuration
 $host = 'localhost';
 $dbname = 'anh';
 $username = 'anh';
 $password = '9kCuzrb5tO53$xQtf';

// Establish connection
$conn = new mysqli($host, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into database
    $sql = "INSERT INTO mail (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
exit; // Ensure no further output
?>