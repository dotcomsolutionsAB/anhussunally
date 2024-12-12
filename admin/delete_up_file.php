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

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Soft delete from upload table
    $stmt = $conn->prepare("UPDATE upload SET deleted_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete file in upload table.");
    }

    // Remove the ID from products table's images column
    $updateProductsQuery = "
        UPDATE products
        SET images = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', images, ','), CONCAT(',', ?, ','), ','))
        WHERE FIND_IN_SET(?, images) > 0
    ";
    $stmt = $conn->prepare($updateProductsQuery);
    $stmt->bind_param("ii", $id, $id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update images column in products table.");
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'File deleted successfully.']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
