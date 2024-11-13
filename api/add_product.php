<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db_connection.php");

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

        // Initialize mandatory fields
        $sku = $csvData['SKU'] ?? '';                // CSV header: 'SKU' -> Database column: 'sku'
        $productName = $csvData['Product Name'] ?? ''; // CSV header: 'Product Name' -> Database column: 'name'
        $brand = $csvData['Brand'] ?? '';            // CSV header: 'Brand' -> Database column: 'brand'
        $category = $csvData['Category'] ?? '';      // CSV header: 'Category' -> Database column: 'category'

        // Skip the row if any mandatory field is missing
        if (empty($sku) || empty($productName) || empty($brand) || empty($category)) {
            $failedRows++;
            continue;
        }

        // Initialize other fields with explicit mapping
        $description = $csvData['Description'] ?? '';       // CSV header: 'Description' -> Database column: 'description'
        $subCategory1 = $csvData['Sub Category Lv 1'] ?? ''; // CSV header: 'Sub Category Lv 1' -> Database column: 'sub_category_1'
        $subCategory2 = $csvData['Sub Category Lv 2'] ?? ''; // CSV header: 'Sub Category Lv 2' -> Database column: 'sub_category_2'
        $subCategory3 = $csvData['Sub Category Lv 3'] ?? ''; // CSV header: 'Sub Category Lv 3' -> Database column: 'sub_category_3'
        $images = $csvData['Images'] ?? '';                 // CSV header: 'Images' -> Database column: 'images'
        $pdf = $csvData['PDF'] ?? '';                       // CSV header: 'PDF' -> Database column: 'pdf'
        // Initialize numeric fields with default values if they are empty
        $weight = !empty($csvData['Weight (Kgs)']) ? $csvData['Weight (Kgs)'] : 0; // Default to 0 if empty
        $length = !empty($csvData['Lenght (cm)']) ? $csvData['Lenght (cm)'] : 0;   // Default to 0 if empty
        $breadth = !empty($csvData['Breadth (cm)']) ? $csvData['Breadth (cm)'] : 0; // Default to 0 if empty
        $height = !empty($csvData['Height (cm)']) ? $csvData['Height (cm)'] : 0;   // Default to 0 if empty
        // CSV header: 'Height (cm)' -> Database column: 'height'

        // Construct Features as an array
            $features = [];
            for ($i = 1; $i <= 12; $i++) {
                if (!empty($csvData["Features $i"])) {
                    $features[] = htmlspecialchars($csvData["Features $i"]);
                }
            }

            // Convert the features array to a JSON string
            $featuresHtml = json_encode($features); // Encode as JSON
            if ($featuresHtml === false) {
                $featuresHtml = '[]'; // Default to an empty JSON array if encoding fails
            }


        // Construct Shop lines as HTML list
        $shopLines = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($csvData["Shop_Line $i"])) {
                $shopLines[] = "<li>" . htmlspecialchars($csvData["Shop_Line $i"]) . "</li>";
            }
        }
        $shopLinesHtml = empty($shopLines) ? '[]' : '[' . implode(', ', $shopLines) . ']'; // Database column: 'shop_lines'

        // Show data fields for clarity
        // echo "Inserting Data for SKU: $sku\n";
        // echo "Product Name: $productName\n";
        // echo "Brand: $brand\n";
        // echo "Category: $category\n";
        // echo "Description: $description\n";
        // echo "Sub Category 1: $subCategory1\n";
        // echo "Sub Category 2: $subCategory2\n";
        // echo "Sub Category 3: $subCategory3\n";
        // echo "Images: $images\n";
        // echo "PDF: $pdf\n";
        // echo "Weight: $weight\n";
        // echo "Length: $length\n";
        // echo "Breadth: $breadth\n";
        // echo "Height: $height\n";
        // echo "Features: $featuresHtml\n";
        // echo "Shop Lines: $shopLinesHtml\n";

        // Prepare columns and values for the insert query
        $columns = ['sku', 'name', 'brand', 'category', 'description', 'sub_category_1', 'sub_category_2', 'sub_category_3', 'images', 'pdf', 'weight', 'length', 'breadth', 'height', 'features', 'shop_lines'];
        $values = [$sku, $productName, $brand, $category, $description, $subCategory1, $subCategory2, $subCategory3, $images, $pdf, $weight, $length, $breadth, $height, $featuresHtml, $shopLinesHtml];

        // Construct the final INSERT query
        $insertQuery = "INSERT INTO products (" . implode(", ", $columns) . ") VALUES (" . implode(", ", array_fill(0, count($values), '?')) . ")";
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
