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

// Fetch URL from google_sheet table where status is 0
$query = "SELECT path FROM google_sheet WHERE status = 0 LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $csvUrl = $row['path'];

    // Fetch CSV content from the URL
    $csvContent = file_get_contents($csvUrl);
    $lines = explode(PHP_EOL, $csvContent);
    $header = str_getcsv(array_shift($lines)); // Get headers

    $totalRows = count($lines);
    $importedRows = 0;
    $failedRows = 0;

    echo "Total rows in the sheet: $totalRows\n";

    // Iterate through each line and process data
    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if (empty($data) || count($data) != count($header)) {
            $failedRows++;
            continue; // Skip if the data line is invalid
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);

        // Mandatory fields
        $sku = $csvData['SKU'] ?? '';
        $productName = $csvData['Product Name'] ?? '';
        $brand = $csvData['Brand'] ?? '';
        $category = $csvData['Category'] ?? '';

        if (empty($sku) || empty($productName) || empty($brand) || empty($category)) {
            $failedRows++;
            continue; // Skip if any mandatory fields are missing
        }

        // Features as HTML list
        $features = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($csvData["Features $i"])) {
                $features[] = "<li>" . htmlspecialchars($csvData["Features $i"]) . "</li>";
            }
        }
        $featuresHtml = '[' . implode(', ', $features) . ']';

        // Shop lines as HTML list
        $shopLines = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($csvData["Shop_Line $i"])) {
                $shopLines[] = "<li>" . htmlspecialchars($csvData["Shop_Line $i"]) . "</li>";
            }
        }
        $shopLinesHtml = '[' . implode(', ', $shopLines) . ']';

        // Check if the product already exists in the database
        $checkQuery = "SELECT * FROM products WHERE sku = ? AND name = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $sku, $productName);
        $stmt->execute();
        $existingProduct = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($existingProduct) {
            // Product exists, check for changes and update if necessary
            $updateFields = [];
            $updateValues = [];

            foreach ($csvData as $column => $value) {
                if ($column != 'SKU' && $column != 'Product Name' && isset($existingProduct[strtolower($column)]) && $existingProduct[strtolower($column)] != $value) {
                    $updateFields[] = "`" . strtolower($column) . "` = ?";
                    $updateValues[] = $value;
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE products SET " . implode(", ", $updateFields) . " WHERE sku = ? AND name = ?";
                $stmt = $conn->prepare($updateQuery);
                $updateValues[] = $sku;
                $updateValues[] = $productName;
                $stmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
                $stmt->execute();
                $stmt->close();
                echo "Product updated: " . $sku . "\n";
            } else {
                echo "No changes detected for: " . $sku . "\n";
            }
            $importedRows++;
        } else {
            // Product does not exist, insert new product
            // Assign values to variables
            $description = $csvData['Description'] ?? '';
            $subCategory1 = $csvData['Sub Category Lv 1'] ?? '';
            $subCategory2 = $csvData['Sub Category Lv 2'] ?? '';
            $subCategory3 = $csvData['Sub Category Lv 3'] ?? '';
            $images = $csvData['Images'] ?? '';
            $pdf = $csvData['PDF'] ?? '';
            $weight = $csvData['Weight (Kgs)'] ?? 0;
            $length = $csvData['Lenght (cm)'] ?? 0; // Corrected spelling: Length
            $breadth = $csvData['Breadth (cm)'] ?? 0;
            $height = $csvData['Height (cm)'] ?? 0;
            $shortDescription = $csvData['Short Description'] ?? '';

            $insertQuery = "INSERT INTO products (sku, name, description, brand, category, sub_category_1, sub_category_2, sub_category_3, images, pdf, weight, length, breadth, height, short_description, features, shop_lines) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param(
                "sssssssssssssssss",
                $sku,
                $productName,
                $description,
                $brand,
                $category,
                $subCategory1,
                $subCategory2,
                $subCategory3,
                $images,
                $pdf,
                $weight,
                $length,
                $breadth,
                $height,
                $shortDescription,
                $featuresHtml,
                $shopLinesHtml
            );

            if ($stmt->execute()) {
                $importedRows++;
                echo "New product added: " . $sku . "\n";
            } else {
                $failedRows++;
                echo "Failed to add product: " . $sku . "\n";
            }
            $stmt->close();
        }
    }

    // Output import summary
    echo "Total rows processed: $totalRows\n";
    echo "Rows successfully imported: $importedRows\n";
    echo "Rows failed to import: $failedRows\n";

    // Update status in google_sheet table
    $updateStatusQuery = "UPDATE google_sheet SET status = 1 WHERE path = ?";
    $stmt = $conn->prepare($updateStatusQuery);
    $stmt->bind_param("s", $csvUrl);
    $stmt->execute();
    $stmt->close();

    echo "Status updated to 1 in google_sheet table.\n";
} else {
    echo "No CSV URL found with status 0.\n";
}

// Close the connection
$conn->close();
?>
