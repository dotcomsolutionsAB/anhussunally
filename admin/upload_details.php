<?php
header('Content-Type: application/json');

include("../connection/db_connect.php");
// Database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Get ID from query string
$id = $_GET['id'];

// Fetch details
$stmt = $conn->prepare("SELECT * FROM upload WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $details = $result->fetch_assoc();
    echo json_encode(['success' => true, 'details' => $details]);
} else {
    echo json_encode(['success' => false, 'message' => 'Item not found.']);
}
?>
