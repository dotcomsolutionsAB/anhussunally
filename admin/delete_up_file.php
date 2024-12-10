<?php
header('Content-Type: application/json');

include("../connection/db_connect.php");

// Database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Get data from POST
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

// Delete query
$stmt = $conn->prepare("UPDATE upload SET deleted_at = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>
