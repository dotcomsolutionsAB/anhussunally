<?php
// Include database connection
include("../../connection/db_connect.php");

// Get the ID and Status from the request
$id = $_GET['id'];
$status = $_GET['status'];

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update status query
$stmt = $conn->prepare("UPDATE google_sheet SET status = ? WHERE id = ?");
$stmt->bind_param("ii", $status, $id);

if ($stmt->execute()) {
    echo "Status updated successfully";
} else {
    echo "Failed to update status";
}

$stmt->close();
$conn->close();
?>
