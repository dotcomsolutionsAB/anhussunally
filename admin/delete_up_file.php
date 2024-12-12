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
    // Fetch the file name before deletion
    $stmt = $conn->prepare("SELECT file_original_name FROM upload WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to fetch file information.");
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("File not found.");
    }
    $row = $result->fetch_assoc();
    $fileName = $row['file_original_name'];
    $filePath = "../uploads/assets/" . $fileName;

    // Delete the record from the upload table
    $stmt = $conn->prepare("DELETE FROM upload WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete file from upload table.");
    }

    // Remove the ID from the products table's images column
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

    // Delete the actual file from the filesystem
    if (file_exists($filePath)) {
        if (!unlink($filePath)) {
            // Log error but don't throw exception to avoid rollback
            error_log("Failed to delete file at $filePath");
        }
    } else {
        // Log that file does not exist
        error_log("File not found at $filePath");
    }

    echo json_encode(['success' => true, 'message' => 'File deleted successfully.']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
