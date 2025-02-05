<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Database connection
    $host = 'localhost';
    $dbname = 'anhuszzw_html';
    $username = 'anhuszzw_html';
    $password = '9kCuzrb5tO53$xQtf';

    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if query parameter 'q' exists and has at least 2 characters
    if (isset($_GET['q']) && strlen($_GET['q']) >= 2) {
        $searchQuery = htmlspecialchars($_GET['q']); // Sanitize user input

        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("
            SELECT 
                p.sku,
                p.name AS product_name,
                c.name AS category_name,
                b.name AS brand_name,
                u.file_original_name AS image
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brand b ON p.brand_id = b.id
            LEFT JOIN upload u ON u.id = CAST(SUBSTRING_INDEX(p.images, ',', 1) AS UNSIGNED)
            WHERE p.name LIKE :searchQuery OR p.sku LIKE :searchQuery
        ");
        // LIMIT 2
        $stmt->execute(['searchQuery' => "%$searchQuery%"]);

        // Fetch results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return results as JSON
        echo json_encode($results);
    } else {
        // Return an empty array if query is less than  characters
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
