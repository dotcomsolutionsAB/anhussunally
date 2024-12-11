<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
// $host = 'localhost';
// $dbname = 'anh';
// $username = 'anh';
// $password = '9kCuzrb5tO53$xQtf';
include("../connection/db_connect.php");

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check the google_sheet table where status is 1 desc limi 1
$sheetQuery = "SELECT id, path, name FROM google_sheet WHERE status = 1 ORDER BY updated_at DESC LIMIT 1";
$sheetResult = $conn->query($sheetQuery);

if ($sheetResult && $sheetResult->num_rows > 0) {
    $sheetRow = $sheetResult->fetch_assoc();
    echo "Processing images for sheet: " . htmlspecialchars($sheetRow['name']) . "<br>";

    // Query to check the products table
    $productQuery = "SELECT sku, image_url, images FROM products WHERE image_url != ''";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        while ($productRow = $productResult->fetch_assoc()) {
            $sku = $productRow['sku'];
            $imageUrl = $productRow['image_url'];
            $imagesColumn = $productRow['images'];

            // Extract the filename from the image URL
            $imageName = basename($imageUrl);

            // Check if the file already exists in the upload table
            $checkImageQuery = "SELECT id FROM upload WHERE file_original_name = ?";
            $checkStmt = $conn->prepare($checkImageQuery);
            $checkStmt->bind_param("s", $imageName);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                // File already exists, get the ID
                $checkStmt->bind_result($imageId);
                $checkStmt->fetch();
                $checkStmt->close();

                // Check if the image ID is already in the images column
                $imageIds = explode(',', $imagesColumn);
                if (!in_array($imageId, $imageIds)) {
                    $imageIds[] = $imageId;
                    $imagesColumn = implode(',', $imageIds);

                    // Update the images column in the products table
                    $updateProductQuery = "UPDATE products SET images = ? WHERE sku = ?";
                    $updateStmt = $conn->prepare($updateProductQuery);
                    $updateStmt->bind_param("ss", $imagesColumn, $sku);

                    if ($updateStmt->execute()) {
                        echo "Images updated for SKU: " . htmlspecialchars($sku) . "<br>";
                    } else {
                        echo "Failed to update images for SKU: " . htmlspecialchars($sku) . "<br>";
                        echo "Error: " . $updateStmt->error . "<br>";
                    }
                    $updateStmt->close();
                } else {
                    echo "Image ID already exists for SKU: " . htmlspecialchars($sku) . "<br>";
                }
            } else {
                // File does not exist, attempt to download and add it
                echo "Attempting to download image: " . htmlspecialchars($imageUrl) . "<br>";
                $imageContents = @file_get_contents($imageUrl);

                if ($imageContents === false) {
                    echo "Failed to download image: " . htmlspecialchars($imageUrl) . "<br>";
                    continue;
                }

                // Save the image to the uploads/assets directory
                $imagePath = "../uploads/assets/" . $imageName;
                if (!file_put_contents($imagePath, $imageContents)) {
                    echo "Failed to save image: " . htmlspecialchars($imagePath) . "<br>";
                    continue;
                }

                // Get image details
                $fileSize = strlen($imageContents);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                $type = mime_content_type($imagePath);
                $userId = 1; // You can change this to the appropriate user ID
                $imageLink = "/uploads/assets/" . $imageName;

                // Insert image details into the upload table
                $insertImageQuery = "INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, created_at)
                                     VALUES (?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($insertImageQuery);
                $stmt->bind_param("ssisss", $imageName, $imageLink, $userId, $fileSize, $extension, $type);

                if ($stmt->execute()) {
                    $imageId = $stmt->insert_id;
                    echo "Image uploaded successfully: " . htmlspecialchars($imageName) . "<br>";

                    // Update the images column in the products table
                    if (!empty($imagesColumn)) {
                        $imagesColumn .= "," . $imageId;
                    } else {
                        $imagesColumn = $imageId;
                    }

                    $updateProductQuery = "UPDATE products SET images = ? WHERE sku = ?";
                    $updateStmt = $conn->prepare($updateProductQuery);
                    $updateStmt->bind_param("ss", $imagesColumn, $sku);

                    if ($updateStmt->execute()) {
                        echo "Images updated for SKU: " . htmlspecialchars($sku) . "<br>";
                    } else {
                        echo "Failed to update images for SKU: " . htmlspecialchars($sku) . "<br>";
                        echo "Error: " . $updateStmt->error . "<br>";
                    }
                    $updateStmt->close();
                } else {
                    echo "Failed to insert image details into the upload table: " . $stmt->error . "<br>";
                }
                $stmt->close();
            }
        }
    } else {
        echo "No products found with valid image URLs." . "<br>";
    }

} else {

    echo "No sheet found with status 1 in google_sheet table." . "<br>";
}

// Update the updated_at column for the google_sheet table
if (isset($sheetRow['id'])) {
    $updateSheetQuery = "UPDATE google_sheet SET updated_at = NOW() WHERE id = ?";
    $updateSheetStmt = $conn->prepare($updateSheetQuery);
    $updateSheetStmt->bind_param("i", $sheetRow['id']);
    
    if ($updateSheetStmt->execute()) {
        echo "Google sheet updated_at column updated successfully for ID: " . htmlspecialchars($sheetRow['id']) . "<br>";
    } else {
        echo "Failed to update updated_at column for google_sheet ID: " . htmlspecialchars($sheetRow['id']) . "<br>";
        echo "Error: " . $updateSheetStmt->error . "<br>";
    }

    $updateSheetStmt->close();
}

// Close the connection
$conn->close();
?>
