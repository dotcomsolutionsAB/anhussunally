<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database Connection
$host = 'localhost';
$user = 'anhuszzw_html';
$password = '9kCuzrb5tO53$xQtf';
$dbname = 'anhuszzw_html';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Directory to store PDFs
$uploadDir = "../uploads/bro/";
$brochureDir = "../uploads/brochure/";

if (!isset($_POST['product_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'Product ID is missing']));
}

$productId = (int)$_POST['product_id'];
$sql = "SELECT id, sku, pdf FROM products WHERE id = ? AND (pdf_id IS NULL OR pdf_id = '') AND pdf IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die(json_encode(['status' => 'error', 'message' => "No valid product found for ID: $productId"]));
}

$row = $result->fetch_assoc();
$sku = $row['sku'];
$pdfValue = trim($row['pdf']);
$pdfId = null;

// Case 1: If PDF is a URL (starting with 'https')
if (preg_match('/^https:\/\//', $pdfValue)) {
    $fileName = basename(parse_url($pdfValue, PHP_URL_PATH)); // Extract filename
    $fileName = preg_replace('/[%\s]+/', '-', $fileName); // Replace % and spaces with '-'
    $filePath = $uploadDir . $fileName;

    $savedFilePath = downloadFile($pdfValue, $filePath);

    if ($savedFilePath) {
        $pdfId = saveToUploads($conn, $fileName, $savedFilePath, "pdf", $pdfValue);
    } else {
        die(json_encode(['status' => 'error', 'message' => "Failed to download PDF for SKU: $sku"]));
    }
}
// Case 2: If PDF is a local filename (like 't019.pdf')
elseif (!empty($pdfValue) && preg_match('/\w+\.pdf$/', $pdfValue)) {
    $existingPath = $brochureDir . $pdfValue;
    $cleanedFileName = preg_replace('/[%\s]+/', '-', $pdfValue); // Ensure filename consistency

    if (file_exists($existingPath)) {
        $pdfId = saveToUploads($conn, $cleanedFileName, $existingPath, "pdf"); // Save without moving
    } else {
        die(json_encode(['status' => 'error', 'message' => "File not found for SKU: $sku, File: $pdfValue"]));
    }
} else {
    die(json_encode(['status' => 'error', 'message' => "Invalid PDF value for SKU: $sku, PDF: $pdfValue"]));
}

// Update products table with the new pdf_id
if ($pdfId !== null) {
    $updateSql = "UPDATE products SET pdf_id = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $pdfId, $productId);
    $stmt->execute();
}

// Return success response
echo json_encode([
    'status' => 'success',
    'message' => "Processed SKU: $sku, PDF: $pdfValue",
    'product_id' => $productId
]);

$conn->close();

/**
 * Function to download a file from a URL
 * Sanitizes the file name by replacing '%' and spaces with '-'
 */
function downloadFile($url, $savePath)
{
    $fileContent = file_get_contents($url);
    if ($fileContent === false) {
        return false;
    }
    return file_put_contents($savePath, $fileContent) !== false ? $savePath : false;
}

/**
 * Function to save file details into the uploads table
 */
function saveToUploads($conn, $originalName, $filePath, $type, $externalLink = null)
{
    $fileSize = filesize($filePath);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $userId = 1;
    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = $createdAt;
    $deletedAt = null;

    $insertSql = "INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, external_link, created_at, updated_at, deleted_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssiissssss", $originalName, $filePath, $userId, $fileSize, $extension, $type, $externalLink, $createdAt, $updatedAt, $deletedAt);
    $stmt->execute();

    return $stmt->insert_id;
}
