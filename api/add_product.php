<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../connection/db_connect.php");
include("add_category.php"); // Include the add_category function

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch URL and sheet name from google_sheet table where status is 0
$query = "SELECT path, name FROM google_sheet WHERE status = 0 LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
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

    $totalRows = 0;
    $importedSKUs = [];
    $updatedSKUs = [];
    $failedSKUs = [];

    echo "Reading SKUs from the sheet: $sheetName" . "<br>";

    // Iterate through each line and process data
    while (($data = fgetcsv($csvFile)) !== false) {
        $totalRows++;
        if (count($data) != count($header)) {
            echo "Skipping invalid line: " . htmlspecialchars(implode(", ", $data)) . "<br>";
            continue;
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);

        // Explicitly initialize variables for each CSV column
        $sku = $csvData['SKU'] ?? '';
        $sku = str_replace(['–', '—'], '-', $sku); // Normalize the SKU: Replace en dash and em dash with hyphen

        $name = $csvData['Product Name'] ?? '';
        $description = $csvData['Description'] ?? '';
        $short_description = $csvData['Short Description'] ?? '';
        $brand = $csvData['Brand'] ?? '';
        $category = $csvData['Category'] ?? '';
        $image_url = $csvData['Images'] ?? ''; // Use image_url from CSV
        $pdf = $csvData['PDF'] ?? '';
        $weight = !empty($csvData['Weight (Kgs)']) ? $csvData['Weight (Kgs)'] : 0;
        $length = !empty($csvData['Lenght (cm)']) ? $csvData['Lenght (cm)'] : 0;
        $breadth = !empty($csvData['Breadth (cm)']) ? $csvData['Breadth (cm)'] : 0;
        $height = !empty($csvData['Height (cm)']) ? $csvData['Height (cm)'] : 0;
        $images = ''; // Default value for images

        // Construct Features as JSON
        $features = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($csvData["Features $i"])) {
                $features[] = "<li>" . htmlspecialchars($csvData["Features $i"]) . "</li>";
            }
        }
        $featuresJson = json_encode($features);

        // Construct Shop lines as JSON
        $shopLines = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($csvData["Shop_Line $i"])) {
                $shopLines[] = "<li>" . htmlspecialchars($csvData["Shop_Line $i"]) . "</li>";
            }
        }
        $shopLinesJson = json_encode($shopLines);

        // Skip the row if any mandatory field is missing
        if (empty($sku) || empty($name) || empty($brand) || empty($category)) {
            $failedSKUs[] = $sku;
            echo "Skipping row due to missing mandatory fields: SKU = $sku" . "<br>";
            continue;
        }

        // Check if the brand exists in the brand table
        $brandId = null;
        $brandCheckQuery = "SELECT id FROM brand WHERE name = ?";
        $brandStmt = $conn->prepare($brandCheckQuery);
        $brandStmt->bind_param("s", $brand);
        $brandStmt->execute();
        $brandResult = $brandStmt->get_result();

        if ($brandResult->num_rows > 0) {
            $brandRow = $brandResult->fetch_assoc();
            $brandId = $brandRow['id'];
        } else {
            // Insert the new brand into the brand table
            $brandInsertQuery = "INSERT INTO brand (name, logo, specifications, extension, created_at, updated_at) VALUES (?, '', '', '', NOW(), NOW())";
            $brandStmt = $conn->prepare($brandInsertQuery);
            $brandStmt->bind_param("s", $brand);

            if ($brandStmt->execute()) {
                $brandId = $conn->insert_id;
                echo "New brand added: $brand (ID: $brandId)" . "<br>";
            } else {
                $failedSKUs[] = $sku;
                echo "Failed to add brand: " . $brand . "<br>";
                echo "Error: " . $brandStmt->error . "<br>";
                continue;
            }
        }
        $brandStmt->close();

        // Call the addCategory function to handle category insertion
        $categoryId = addCategory($category); // Get the category_id from add_category.php

        if ($categoryId) {
            // Check if the SKU already exists in the products table
            $checkQuery = "SELECT * FROM products WHERE sku = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $sku);
            $checkStmt->execute();
            $existingProduct = $checkStmt->get_result()->fetch_assoc();
            $checkStmt->close();

            if ($existingProduct) {
                // Check for any updates needed
                $updateFields = [];
                $updateValues = [];

                if ($existingProduct['name'] != $name) {
                    $updateFields[] = "name = ?";
                    $updateValues[] = $name;
                }
                if ($existingProduct['descriptions'] != $description) {
                    $updateFields[] = "descriptions = ?";
                    $updateValues[] = $description;
                }
                if ($existingProduct['short_description'] != $short_description) {
                    $updateFields[] = "short_description = ?";
                    $updateValues[] = $short_description;
                }
                if ($existingProduct['brand_id'] != $brandId) {
                    $updateFields[] = "brand_id = ?";
                    $updateValues[] = $brandId;
                }
                if ($existingProduct['category_id'] != $categoryId) {
                    $updateFields[] = "category_id = ?";
                    $updateValues[] = $categoryId;
                }
                if ($existingProduct['image_url'] != $image_url) {
                    $updateFields[] = "image_url = ?";
                    $updateValues[] = $image_url;
                }
                if ($existingProduct['pdf'] != $pdf) {
                    $updateFields[] = "pdf = ?";
                    $updateValues[] = $pdf;
                }
                if ($existingProduct['weight'] != $weight) {
                    $updateFields[] = "weight = ?";
                    $updateValues[] = $weight;
                }
                if ($existingProduct['length'] != $length) {
                    $updateFields[] = "length = ?";
                    $updateValues[] = $length;
                }
                if ($existingProduct['breadth'] != $breadth) {
                    $updateFields[] = "breadth = ?";
                    $updateValues[] = $breadth;
                }
                if ($existingProduct['height'] != $height) {
                    $updateFields[] = "height = ?";
                    $updateValues[] = $height;
                }
                if ($existingProduct['features'] != $featuresJson) {
                    $updateFields[] = "features = ?";
                    $updateValues[] = $featuresJson;
                }
                if ($existingProduct['shop_lines'] != $shopLinesJson) {
                    $updateFields[] = "shop_lines = ?";
                    $updateValues[] = $shopLinesJson;
                }

                if (!empty($updateFields)) {
                    // Prepare the update query
                    $updateQuery = "UPDATE products SET " . implode(", ", $updateFields) . " WHERE sku = ?";
                    $updateValues[] = $sku; // Add SKU to the end of the values array
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param(str_repeat("s", count($updateValues) - 1) . "s", ...$updateValues);

                    if ($stmt->execute()) {
                        $updatedSKUs[] = $sku;
                        echo "Product updated: " . $sku . "<br>";
                    } else {
                        $failedSKUs[] = $sku;
                        echo "Failed to update product: " . $sku . "<br>";
                        echo "Error: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "No changes detected for: " . $sku . "<br>";
                }
            } else {
                // Insert new product with the brand ID
                $insertQuery = "INSERT INTO products (sku, name, descriptions, short_description, brand_id, category_id, images, image_url, pdf, weight, length, breadth, height, features, shop_lines)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("sssssssssddddss", $sku, $name, $description, $short_description, $brandId, $categoryId, $images, $image_url, $pdf, $weight, $length, $breadth, $height, $featuresJson, $shopLinesJson);

                if ($stmt->execute()) {
                    $importedSKUs[] = $sku;
                    echo "New product added: " . $sku . "<br>";
                } else {
                    $failedSKUs[] = $sku;
                    echo "Failed to add product: " . $sku . "<br>";
                    echo "Error: " . $stmt->error . "<br>";
                }
                $stmt->close();
            }
        }
    }

    // Output import summary by SKU in a structured format
    echo "\nSummary for sheet: $sheetName" . "<br>";
    echo "------------------------" . "<br>";
    echo "Total SKUs processed: $totalRows" . "<br>";
    echo "SKUs successfully imported: " . (!empty($importedSKUs) ? implode(", ", $importedSKUs) : "None") . "<br>";
    echo "SKUs updated: " . (!empty($updatedSKUs) ? implode(", ", $updatedSKUs) : "None") . "<br>";
    echo "SKUs failed to import or update: " . (!empty($failedSKUs) ? implode(", ", $failedSKUs) : "None") . "<br>";
    echo "------------------------" . "<br>";

    // Update the status if at least one product was successfully imported or updated
    $updateStatusQuery = "UPDATE google_sheet SET status = 1 WHERE path = ?";
    $stmt = $conn->prepare($updateStatusQuery);
    $stmt->bind_param("s", $csvUrl);
    $stmt->execute();
    $stmt->close();

    echo "Status updated to 1 in google_sheet table for sheet: $sheetName" . "<br>";

    fclose($csvFile); // Close the CSV file
} else {
    echo "No CSV URL found with status 0" . "<br>";
}

// Close the connection
$conn->close();
?>
