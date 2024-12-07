<?php
// Include database connection
include("../../connection/db_connect.php");

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID and new status from the request
$id = $_GET['id'];
$status = $_GET['status'];

// Update the status of the specified sheet
$query = "UPDATE google_sheet SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $status, $id);
if ($stmt->execute()) {
    echo "Status updated successfully.";
} else {
    echo "Error updating status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
