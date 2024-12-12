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
    $result = $conn->query("
        SELECT p.*, c.name as category_name, b.name as brand_name 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        WHERE p.name LIKE '%$searchQuery%' 
           OR p.sku LIKE '%$searchQuery%' 
           OR b.name LIKE '%$searchQuery%'
        ORDER BY p.name ASC
    ");
    
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
