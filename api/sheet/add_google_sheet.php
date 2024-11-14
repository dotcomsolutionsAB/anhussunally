<?php
// Include database connection
include("../api/db_connection.php");

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$sheet_name = $_POST['sheet_name'];
$sheet_path = $_POST['sheet_path'];

// Insert into google_sheet table
$query = "INSERT INTO google_sheet (name, path, status) VALUES (?, ?, 1)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sheet_name, $sheet_path);

if ($stmt->execute()) {
    // Redirect back to the main page
    header("Location: view_google_sheets.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
