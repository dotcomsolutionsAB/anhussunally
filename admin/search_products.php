<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$dbname = 'anh';
$username = 'anh';
$password = '9kCuzrb5tO53$xQtf';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
if (isset($_GET['query']) && strlen(trim($_GET['query'])) >= 2) {
    $searchQuery = $conn->real_escape_string($_GET['query']);
    $query = "
        SELECT 
            products.*, 
            brand.name AS brand_name, 
            categories.name AS category_name 
        FROM products 
        LEFT JOIN brand ON products.brand_id = brand.id 
        LEFT JOIN categories ON products.category_id = categories.id 
        WHERE products.name LIKE '%$searchQuery%' 
           OR products.sku LIKE '%$searchQuery%' 
           OR brand.name LIKE '%$searchQuery%'
    ";
    $result = $conn->query($query);

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imageIDs = explode(',', trim($row['images'], ',')); // Extract image IDs
            $firstImageID = $imageIDs[0] ?? null;

            // Fetch the first image file name
            $imageName = null;
            if ($firstImageID) {
                $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageID";
                $imageResult = $conn->query($imageQuery);
                if ($imageResult && $imageResult->num_rows > 0) {
                    $imageRow = $imageResult->fetch_assoc();
                    $imageName = $imageRow['file_original_name'];
                }
            }

            $data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'sku' => $row['sku'],
                'short_description' => $row['short_description'],
                'brand_name' => $row['brand_name'],
                'category_name' => $row['category_name'],
                'weight' => $row['weight'],
                'length' => $row['length'],
                'breadth' => $row['breadth'],
                'height' => $row['height'],
                'image' => $imageName ? "../uploads/assets/$imageName" : null, // Construct the image path
            ];
        }
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
