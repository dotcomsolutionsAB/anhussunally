

<?php
// Database configuration
$host = 'localhost';
$dbname = 'anh';
$username = 'anh';
$password = '9kCuzrb5tO53$xQtf';
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    
    // Search query for SKU and name
    $sql = "SELECT sku, name, price, image_url FROM products WHERE sku LIKE '%$search%' OR name LIKE '%$search%' LIMIT 5";  // Limiting to 5 results
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Prepare results in an array
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        // Return results as JSON
        echo json_encode($products);
    } else {
        echo json_encode([]);  // No results found
    }
}

$conn->close();
?>
