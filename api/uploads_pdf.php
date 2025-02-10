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
    die("Connection failed: " . $conn->connect_error);
}

// Directory to store PDFs
$uploadDir = "../uploads/bro/";
$brochureDir = "../uploads/brochure/";

// Fetch all products where pdf_id is NULL and pdf is not empty
$sql = "SELECT id, sku, pdf FROM products WHERE (pdf_id IS NULL OR pdf_id = '') AND pdf IS NOT NULL";
$result = $conn->query($sql);

$totalProcessed = 0;
$errors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['id'];
        $sku = $row['sku'];
        $pdfValue = trim($row['pdf']);
        $pdfId = null;

        echo "Processing SKU: $sku, PDF: $pdfValue\n";

        // Case 1: If PDF is a URL (starting with 'https')
        if (preg_match('/^https:\/\//', $pdfValue)) {
            $fileName = basename(parse_url($pdfValue, PHP_URL_PATH)); // Extract filename
            $filePath = $uploadDir . $fileName;

            if (downloadFile($pdfValue, $filePath)) {
                $pdfId = saveToUploads($conn, $fileName, $filePath, "pdf", $pdfValue);
                echo "Downloaded and saved: $fileName\n";
            } else {
                $errors[] = "Failed to download PDF for SKU: $sku, URL: $pdfValue";
                continue;
            }
        }
        // Case 2: If PDF is a local filename (like 't019.pdf')
        elseif (!empty($pdfValue) && preg_match('/\w+\.pdf$/', $pdfValue)) {
            $existingPath = $brochureDir . $pdfValue; // Check in brochure directory

            if (file_exists($existingPath)) {
                $pdfId = saveToUploads($conn, $pdfValue, $existingPath, "pdf"); // Save without moving
                echo "File exists in brochure directory, recorded in DB: $pdfValue\n";
            } else {
                $errors[] = "File not found for SKU: $sku, File: $pdfValue";
                continue;
            }
        } else {
            $errors[] = "Invalid PDF value for SKU: $sku, PDF: $pdfValue";
            continue;
        }


        // Update products table with the new pdf_id
        if ($pdfId !== null) {
            $updateSql = "UPDATE products SET pdf_id = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ii", $pdfId, $productId);
            $stmt->execute();
            echo "Updated pdf_id for SKU: $sku\n";
        }

        $totalProcessed++;
    }
} else {
    echo "No products found with NULL pdf_id and existing PDF data.\n";
}

$conn->close();

echo "\nTotal Processed: $totalProcessed\n";
if (!empty($errors)) {
    echo "Errors:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}

// Function to download a file from a URL
function downloadFile($url, $savePath)
{
    $fileContent = file_get_contents($url);
    if ($fileContent === false) {
        return false;
    }
    return file_put_contents($savePath, $fileContent) !== false;
}

// Function to save file details into the uploads table
function saveToUploads($conn, $originalName, $filePath, $type, $externalLink = null)
{
    $fileSize = filesize($filePath);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $userId = 1; // Set the user ID dynamically if needed
    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = $createdAt;
    $deletedAt = null;

    $insertSql = "INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, external_link, created_at, updated_at, deleted_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssiissssss", $originalName, $filePath, $userId, $fileSize, $extension, $type, $externalLink, $createdAt, $updatedAt, $deletedAt);
    $stmt->execute();

    return $stmt->insert_id; // Return the ID of the inserted row
}
