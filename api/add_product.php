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

// Function to create a column if it does not exist
function createColumnIfNotExists($conn, $tableName, $columnName, $columnType) {
    $checkQuery = "SHOW COLUMNS FROM `$tableName` LIKE '$columnName'";
    $result = $conn->query($checkQuery);
    if ($result->num_rows == 0) {
        $alterQuery = "ALTER TABLE `$tableName` ADD `$columnName` $columnType";
        $conn->query($alterQuery);
    }
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

    // Check and create columns if they do not exist
    foreach ($header as $column) {
        $sanitizedColumn = str_replace(' ', '_', strtolower($column)); // Replace spaces with underscores
        createColumnIfNotExists($conn, 'products', $sanitizedColumn, 'VARCHAR(255)'); // Default type as VARCHAR(255)
    }

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
            echo "No changes detected for: " . $sku . "\n";
            $importedRows++;
        } else {
            // Product does not exist, insert new product
            // Prepare columns and values for the insert query
            $columns = [];
            $placeholders = [];
            $values = [];

            foreach ($csvData as $column => $value) {
                $sanitizedColumn = str_replace(' ', '_', strtolower($column)); // Replace spaces with underscores
                $columns[] = "`$sanitizedColumn`";
                $placeholders[] = '?';
                $values[] = $value;
            }

            // Add features and shop lines
            $columns[] = "`features`";
            $placeholders[] = '?';
            $values[] = $featuresHtml;

            $columns[] = "`shop_lines`";
            $placeholders[] = '?';
            $values[] = $shopLinesHtml;

            $insertQuery = "INSERT INTO products (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param(str_repeat("s", count($values)), ...$values);

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
