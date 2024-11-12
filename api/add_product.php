<?php
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

    // Iterate through each line and process data
    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if (empty($data) || count($data) != count($header)) {
            continue; // Skip if the data line is invalid
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);

        // Mandatory fields
        $sku = $csvData['SKU'] ?? '';
        $productName = $csvData['Product Name'] ?? '';

        if (empty($sku) || empty($productName)) {
            continue; // Skip if mandatory fields are missing
        }

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
                if ($column != 'SKU' && $column != 'Product Name' && $existingProduct[strtolower($column)] != $value) {
                    $updateFields[] = strtolower($column) . " = ?";
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
        } else {
            // Product does not exist, insert new product
            $insertQuery = "INSERT INTO products (sku, name, description, brand, category, sub_category_1, sub_category_2, sub_category_3, images, pdf, weight, length, breadth, height, sd_title, sd_title_2, features, shop_lines) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param(
                "ssssssssssssssssss",
                $sku,
                $productName,
                $csvData['Description'],
                $csvData['Brand'],
                $csvData['Category'],
                $csvData['Sub Category Lv 1'],
                $csvData['Sub Category Lv 2'],
                $csvData['Sub Category Lv 3'],
                $csvData['Images'],
                $csvData['PDF'],
                $csvData['Weight (Kgs)'],
                $csvData['Length (cm)'],
                $csvData['Breadth (cm)'],
                $csvData['Height (cm)'],
                $csvData['SD Title'],
                $csvData['SD Title_2'],
                json_encode(array_slice($csvData, 17, 10)), // Features as JSON
                json_encode(array_slice($csvData, 27, 5))   // Shop lines as JSON
            );
            $stmt->execute();
            $stmt->close();
            echo "New product added: " . $sku . "\n";
        }
    }

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
