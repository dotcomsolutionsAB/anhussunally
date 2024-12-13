<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../connection/db_connect.php");
include("add_category.php"); // Include the add_category function

// Utility function to log errors
function logError($message) {
    file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    logError("Connection failed: " . mysqli_connect_error());
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
        logError("Failed to open the CSV file: $csvUrl");
        die("Failed to open the CSV file.");
    }

    $header = fgetcsv($csvFile); // Get headers
    if ($header === false) {
        logError("Failed to read the header row from the CSV file: $csvUrl");
        die("Failed to read the header row from the CSV file.");
    }

    $totalRows = 0;
    $importedSKUs = [];
    $updatedSKUs = [];
    $failedSKUs = [];

    echo "Reading SKUs from the sheet: $sheetName<br>";

    // Function to handle category hierarchy
    function addCategoryHierarchy($categories) {
        $parentId = 0; // Top-level starts with no parent
        foreach ($categories as $category) {
            if (!empty($category)) {
                $parentId = addCategory($category, $parentId);
            }
        }
        return $parentId;
    }

    // Iterate through each line and process data
    while (($data = fgetcsv($csvFile)) !== false) {
        $totalRows++;
        if (count($data) != count($header)) {
            echo "Skipping invalid line: " . htmlspecialchars(implode(", ", $data)) . "<br>";
            continue;
        }

        // Map CSV data to column names
        $csvData = array_combine($header, $data);

        // Extract and normalize product data
        $sku = isset($csvData['SKU']) ? trim(str_replace(['–', '—', '/'], '-', $csvData['SKU'])) : '';
        $name = isset($csvData['Product Name']) ? trim(str_replace(['–', '—', '/'], '-', $csvData['Product Name'])) : '';
        $brand = isset($csvData['Brand']) ? trim(str_replace(['–', '—', '/'], ',', $csvData['Brand'])) : '';

        // echo $sku;
        // echo "<br> he ";
        // echo $name . "<br> : name ";
        // echo "<br> he ";
        // echo $brand;
        // echo "<br> he ";
        // Check if any value is empty, whitespace, or not set
        if (empty($sku)) {
            die("Error: SKU cannot be empty or consist of only spaces.");
        }
        // Check if any value is empty, whitespace, or not set
        if (empty($brand) || trim($brand) === '') {
            die("Error:  Brand cannot be empty or consist of only spaces.");
        }
        // Check if any value is empty, whitespace, or not set
        if (empty($name) || trim($name) === '' ) {
            die("Error:  Product Name cannot be empty or consist of only spaces.");
        }
        // Check if any value is empty, whitespace, or not set
        if (empty($sku) || empty($name) || empty($brand)) {
            die("Error: SKU, Product Name, or Brand cannot be empty or consist of only spaces.");
        }

        // If all values are valid, continue with your code
        $description = $csvData['Description'] ?? NULL;
        $short_description = $csvData['Short Description'] ?? NULL;
        

        // Skip rows with missing mandatory fields
        if (empty($sku) || empty($name) || empty($brand) || empty($csvData['Category'])) {
            $failedSKUs[] = $sku;
            echo "Skipping row due to missing mandatory fields: SKU = $sku<br>";
            continue;
        }

        // Process category hierarchy
        $categoryId = addCategoryHierarchy([
            $csvData['Category'],
            $csvData['Sub Category Lv 1'] ?? '',
            $csvData['Sub Category Lv 2'] ?? '',
            $csvData['Sub Category Lv 3'] ?? ''
        ]);

        if (!$categoryId) {
            $failedSKUs[] = $sku;
            echo "Failed to process category hierarchy for SKU: $sku<br>";
            continue;
        }

        $image_url = $csvData['Images'] ?? '';
        $pdf = $csvData['PDF'] ?? '';
        $weight = !empty($csvData['Weight (Kgs)']) ? $csvData['Weight (Kgs)'] : 0;
        $length = !empty($csvData['Lenght (cm)']) ? $csvData['Lenght (cm)'] : 0;
        $breadth = !empty($csvData['Breadth (cm)']) ? $csvData['Breadth (cm)'] : 0;
        $height = !empty($csvData['Height (cm)']) ? $csvData['Height (cm)'] : 0;
        $images = 0; // Default value for images

        // Construct features and shop lines

        // Extract feature columns dynamically
        $features = [];
        $shopLines = [];

        foreach ($csvData as $key => $value) {
            // Check for keys starting with 'feature' (case-insensitive)
            if (stripos($key, 'feature') === 0) {
                $features[] = htmlspecialchars(trim($value)); // Sanitize and add to features
            }

            // Check for keys starting with 'Shop_line' (case-insensitive)
            if (stripos($key, 'Shop_line') === 0) {
                $shopLines[] = htmlspecialchars(trim($value)); // Sanitize and add to shopLines
            }
        }

        // Filter out any empty or null values
        $features = array_filter($features);
        $shopLines = array_filter($shopLines);

        // Assign JSON or null
        $featuresJson = !empty($features) ? json_encode($features) : null;
        $shopLinesJson = !empty($shopLines) ? json_encode($shopLines) : null;

        // // Print the extracted data
        // echo "Extracted Features:\n";
        // echo "<pre>";
        // print_r($features);
        // echo "</pre>";

        // echo "\nExtracted Shop Lines:\n";
        // echo "<pre>";
        // print_r($shopLines);
        // echo "</pre>";

        // echo "\nFeatures JSON:\n";
        // echo "<pre>";
        // echo $featuresJson;
        // echo "</pre>";

        // echo "\nShop Lines JSON:\n";
        // echo "<pre>";
        // echo $shopLinesJson;
        // echo "</pre>";

        // die;
        
        // Check or insert brand
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
            $brandInsertQuery = "INSERT INTO brand (name, logo, specifications, extension, created_at, updated_at) VALUES (?, '', '', '', NOW(), NOW())";
            $brandStmt = $conn->prepare($brandInsertQuery);
            $brandStmt->bind_param("s", $brand);

            if ($brandStmt->execute()) {
                $brandId = $conn->insert_id;
                echo "New brand added: $brand (ID: $brandId)<br>";
            } else {
                logError("Failed to add brand: $brand. Error: " . $brandStmt->error);
                $failedSKUs[] = $sku;
                echo "Failed to add brand: $brand<br>";
                continue;
            }
        }
        $brandStmt->close();

        // Check if product exists
        $checkQuery = "SELECT * FROM products WHERE sku = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $sku);
        $checkStmt->execute();
        $existingProduct = $checkStmt->get_result()->fetch_assoc();
        $checkStmt->close();

        if ($existingProduct) {
            // Update product
            $updateQuery = "UPDATE products SET name = ?, descriptions = ?, short_description = ?, brand_id = ?, category_id = ?, image_url = ?,images=?, pdf = ?, weight = ?, length = ?, breadth = ?, height = ?, features = ?, shop_lines = ? WHERE sku = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssssssssddddsss", $name, $description, $short_description, $brandId, $categoryId, $image_url,$images, $pdf, $weight, $length, $breadth, $height, $featuresJson, $shopLinesJson, $sku);

            if ($stmt->execute()) {
                $updatedSKUs[] = $sku;
                echo "Product updated: $sku<br>";
            } else {
                logError("Failed to update product: $sku. Error: " . $stmt->error);
                $failedSKUs[] = $sku;
                echo "Failed to update product: $sku<br>";
            }
            $stmt->close();
        } else {
            // Insert new product
            $insertQuery = "INSERT INTO products (sku, name, descriptions, short_description, brand_id, category_id, image_url,images, pdf, weight, length, breadth, height, features, shop_lines) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssssssssddddss", $sku, $name, $description, $short_description, $brandId, $categoryId, $image_url,$images, $pdf, $weight, $length, $breadth, $height, $featuresJson, $shopLinesJson);

            if ($stmt->execute()) {
                $importedSKUs[] = $sku;
                echo "New product added: $sku<br>";
            } else {
                logError("Failed to add product: $sku. Error: " . $stmt->error);
                $failedSKUs[] = $sku;
                echo "Failed to add product: $sku<br>";
            }
            $stmt->close();
        }
    }

    // Output summary
    echo "Summary for sheet: $sheetName<br>";
    echo "Total SKUs processed: $totalRows<br>";
    echo "Imported SKUs: " . implode(", ", $importedSKUs) . "<br>";
    echo "Updated SKUs: " . implode(", ", $updatedSKUs) . "<br>";
    echo "Failed SKUs: " . implode(", ", $failedSKUs) . "<br>";

    // Mark sheet as processed
    $updateStatusQuery = "UPDATE google_sheet SET status = 1 WHERE path = ?";
    $stmt = $conn->prepare($updateStatusQuery);
    $stmt->bind_param("s", $csvUrl);
    $stmt->execute();
    $stmt->close();

    fclose($csvFile);
} else {
    echo "No unprocessed sheets found.<br>";
}

$conn->close();
?>
