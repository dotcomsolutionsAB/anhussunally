<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$dbname = 'anh';
$username = 'anh';
$password = '9kCuzrb5tO53$xQtf';

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check the status from google_sheet table
$query = "SELECT id, path, name FROM google_sheet WHERE status = 1 LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sheetId = $row['id'];
    $csvUrl = $row['path'];
    $sheetName = $row['name'];

    // Open the CSV file
    $csvFile = fopen($csvUrl, 'r');
    if ($csvFile === false) {
        die("Failed to open the CSV file.");
    }

    $header = fgetcsv($csvFile); // Get headers
    if ($header === false) {
        die("Failed to read the header row from the CSV file.");
    }

    echo "Processing images from the sheet: $sheetName...\n\n";

    // Iterate through each line and process data
    while (($data = fgetcsv($csvFile)) !== false) {
        if (count($data) != count($header)) {
            echo "Skipping invalid line: " . htmlspecialchars(implode(", ", $data)) . "\n";
            continue; // Skip if the data line is invalid
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);
        $sku = $csvData['SKU'] ?? '';
        $images = $csvData['Images'] ?? '';

        // Skip if SKU or images are empty
        if (empty($sku) || empty($images)) {
            continue;
        }

        // Check if the images column in the products table is empty
        $checkQuery = "SELECT images FROM products WHERE sku = ? AND (images IS NULL OR images = '')";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $sku);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Images need to be downloaded and uploaded
            $imageUrls = explode(',', $images);
            $imageIds = [];

            foreach ($imageUrls as $imageUrl) {
                $imageUrl = trim($imageUrl);
                if (empty($imageUrl)) {
                    continue;
                }

                // Download the image
                $imageContents = @file_get_contents($imageUrl);
                if ($imageContents === false) {
                    echo "Failed to download image: $imageUrl\n";
                    continue;
                }

                // Get image details
                $imageName = basename($imageUrl);
                $imagePath = __DIR__ . "/uploads/assets/" . $imageName;
                $fileSize = strlen($imageContents);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                $type = mime_content_type($imagePath);

                // Save the image to the uploads/assets directory
                if (!file_put_contents($imagePath, $imageContents)) {
                    echo "Failed to save image: $imagePath\n";
                    continue;
                }

                // Insert image details into the upload table
                $insertImageQuery = "INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, created_at)
                                     VALUES (?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($insertImageQuery);
                $userId = 1; // You can change this to the appropriate user ID
                $imageLink = "/uploads/assets/" . $imageName;
                $stmt->bind_param("ssisss", $imageName, $imageLink, $userId, $fileSize, $extension, $type);

                if ($stmt->execute()) {
                    $imageIds[] = $stmt->insert_id;
                    echo "Image uploaded successfully: $imageName\n";
                } else {
                    echo "Failed to insert image details into the upload table: " . $stmt->error . "\n";
                }
                $stmt->close();
            }

            // Update the images column in the products table
            if (!empty($imageIds)) {
                $imageIdsString = implode(",", $imageIds);
                $updateProductQuery = "UPDATE products SET images = ? WHERE sku = ?";
                $updateStmt = $conn->prepare($updateProductQuery);
                $updateStmt->bind_param("ss", $imageIdsString, $sku);

                if ($updateStmt->execute()) {
                    echo "Images updated for SKU: $sku\n";
                } else {
                    echo "Failed to update images for SKU: $sku\n";
                    echo "Error: " . $updateStmt->error . "\n";
                }
                $updateStmt->close();
            }
        }
        $checkStmt->close();
    }

    fclose($csvFile); // Close the CSV file
} else {
    echo "No CSV URL found with status 1 or no images to process.\n";
}

// Close the connection
$conn->close();
?>
