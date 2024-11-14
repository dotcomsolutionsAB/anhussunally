<?php
// Include database connection
include("../api/db_connection.php");

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the Google Sheet ID
$sheet_id = $_GET['id'];

// Update the status to 0
$updateQuery = "UPDATE google_sheet SET status = 0 WHERE id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $sheet_id);

if ($stmt->execute()) {
    echo "Status updated successfully. Synchronization in progress...";

    // Run the add_product and upload_images scripts after 10 seconds
    sleep(10); // Delay execution for 10 seconds
    exec("php add_product.php");
    exec("php upload_images.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
