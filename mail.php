<?php

 // Database configuration
 $host = 'localhost';
 $dbname = 'anh';
 $username = 'anh';
 $password = '9kCuzrb5tO53$xQtf';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data (same as before)
    // Send a JSON response
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }
}


// Close the connection
$conn->close();
?>
