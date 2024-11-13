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

        // Explicitly initialize variables for each CSV column
        $sku = $csvData['SKU'] ?? '';                // CSV: 'SKU' -> DB: 'sku'
        $name = $csvData['Product Name'] ?? '';      // CSV: 'Product Name' -> DB: 'name'
        $description = $csvData['Description'] ?? ''; // CSV: 'Description' -> DB: 'description'
        $short_description=$csvData['Short Description'] ?? '';
        $brand = $csvData['Brand'] ?? '';            // CSV: 'Brand' -> DB: 'brand'
        $category = $csvData['Category'] ?? '';      // CSV: 'Category' -> DB: 'category'
        $subCategory1 = $csvData['Sub Category Lv 1'] ?? ''; // CSV: 'Sub Category Lv 1' -> DB: 'sub_category_1'
        $subCategory2 = $csvData['Sub Category Lv 2'] ?? ''; // CSV: 'Sub Category Lv 2' -> DB: 'sub_category_2'
        $subCategory3 = $csvData['Sub Category Lv 3'] ?? ''; // CSV: 'Sub Category Lv 3' -> DB: 'sub_category_3'
        $images = $csvData['Images'] ?? '';                 // CSV: 'Images' -> DB: 'images'
        $pdf = $csvData['PDF'] ?? '';                       // CSV: 'PDF' -> DB: 'pdf'
        $weight = !empty($csvData['Weight (Kgs)']) ? $csvData['Weight (Kgs)'] : 0; // CSV: 'Weight (Kgs)' -> DB: 'weight'
        $length = !empty($csvData['Lenght (cm)']) ? $csvData['Lenght (cm)'] : 0;   // CSV: 'Lenght (cm)' -> DB: 'length'
        $breadth = !empty($csvData['Breadth (cm)']) ? $csvData['Breadth (cm)'] : 0; // CSV: 'Breadth (cm)' -> DB: 'breadth'
        $height = !empty($csvData['Height (cm)']) ? $csvData['Height (cm)'] : 0;   // CSV: 'Height (cm)' -> DB: 'height'

        // Skip the row if any mandatory field is missing
        if (empty($sku) || empty($name) || empty($brand) || empty($category)) {
            $failedRows++;
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
            $importedRows++;
            echo "New product added: " . $sku . "\n";
        } else {
            $failedRows++;
            echo "Failed to add product: " . $sku . "\n";
        }
        $stmt->close();
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
