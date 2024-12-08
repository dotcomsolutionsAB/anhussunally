<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Database connection
    $host = 'localhost';
    $dbname = 'anh';
    $username = 'anh';
    $password = '9kCuzrb5tO53$xQtf';

    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if query parameter 'q' exists and has at least 3 characters
    if (isset($_GET['q']) && strlen($_GET['q']) >= 3) {
        $searchQuery = htmlspecialchars($_GET['q']); // Sanitize user input

        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("
            SELECT sku, name, brand_id
            FROM products
            WHERE name LIKE :searchQuery OR sku LIKE :searchQuery
            LIMIT 5
        ");
        $stmt->execute(['searchQuery' => "%$searchQuery%"]);

        // Fetch results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return results as JSON
        echo json_encode($results);
    } else {
        // Return an empty array if query is less than 3 characters
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
