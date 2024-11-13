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
    $lines = array_filter(array_map('trim', explode(PHP_EOL, $csvContent))); // Trim and filter empty lines
    $header = str_getcsv(array_shift($lines)); // Get headers

    $totalRows = count($lines);
    $importedSKUs = [];
    $failedSKUs = [];

    echo "Total SKUs in the sheet: $totalRows\n";

    // Iterate through each line and process data
    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if (empty($data) || count($data) != count($header)) {
            continue; // Skip if the data line is invalid
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);
        echo "<pre>";
        die($csvData);
        // Explicitly initialize variables for each CSV column
        $sku = $csvData['SKU'] ?? '';
        $sku = str_replace(['–', '—'], '-', $sku); // Normalize the SKU: Replace en dash and em dash with hyphen

        $name = $csvData['Product Name'] ?? '';
        $description = $csvData['Description'] ?? '';
        $short_description = $csvData['Short Description'] ?? '';
        $brand = $csvData['Brand'] ?? '';
        $category = $csvData['Category'] ?? '';
        $subCategory1 = $csvData['Sub Category Lv 1'] ?? '';
        $subCategory2 = $csvData['Sub Category Lv 2'] ?? '';
        $subCategory3 = $csvData['Sub Category Lv 3'] ?? '';
        $images = $csvData['Images'] ?? '';
        $pdf = $csvData['PDF'] ?? '';
        $weight = !empty($csvData['Weight (Kgs)']) ? $csvData['Weight (Kgs)'] : 0;
        $length = !empty($csvData['Lenght (cm)']) ? $csvData['Lenght (cm)'] : 0;
        $breadth = !empty($csvData['Breadth (cm)']) ? $csvData['Breadth (cm)'] : 0;
        $height = !empty($csvData['Height (cm)']) ? $csvData['Height (cm)'] : 0;

        // Skip the row if any mandatory field is missing
        if (empty($sku) || empty($name) || empty($brand) || empty($category)) {
            $failedSKUs[] = $sku;
            continue;
        }

        // Check if the SKU already exists in the database
        $checkQuery = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $sku);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // SKU already exists, skip insertion
            $failedSKUs[] = $sku;
            echo "SKU already exists: " . $sku . "\n";
            continue;
        }

        // Construct Features as JSON
        $features = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($csvData["Features $i"])) {
                $features[] = htmlspecialchars($csvData["Features $i"]);
            }
        }
        $featuresJson = json_encode($features);

        // Construct Shop lines as JSON
        $shopLines = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($csvData["Shop_Line $i"])) {
                $shopLines[] = htmlspecialchars($csvData["Shop_Line $i"]);
            }
        }
        $shopLinesJson = json_encode($shopLines);

        // Construct the final INSERT query with explicitly initialized variables
        $insertQuery = "INSERT INTO products (sku, name, description, short_description, brand, category, sub_category_1, sub_category_2, sub_category_3, images, pdf, weight, length, breadth, height, features, shop_lines)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssssssssddddss", $sku, $name, $description, $short_description, $brand, $category, $subCategory1, $subCategory2, $subCategory3, $images, $pdf, $weight, $length, $breadth, $height, $featuresJson, $shopLinesJson);

        if ($stmt->execute()) {
            $importedSKUs[] = $sku;
            echo "New product added: " . $sku . "\n";
        } else {
            $failedSKUs[] = $sku;
            echo "Failed to add product: " . $sku . "\n";
            echo "Error: " . $stmt->error . "\n"; // Output the specific error message
        }
        $stmt->close();
    }

    // Output import summary by SKU
    echo "Total SKUs processed: $totalRows\n";
    echo "SKUs successfully imported: " . implode(", ", $importedSKUs) . "\n";
    echo "SKUs failed to import: " . implode(", ", $failedSKUs) . "\n";

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
