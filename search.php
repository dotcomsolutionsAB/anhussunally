<?php
// db_connect.php: Include your database connection
include("connection/db_connect.php");

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']); // Prevent SQL injection

    // Query to search for products by SKU or name
    $sql = "
        SELECT * FROM products 
        WHERE sku LIKE '%$searchQuery%' 
        OR name LIKE '%$searchQuery%' 
        LIMIT 5"; // Limit to 5 results for better performance

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Display the products
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result-item'>";
            echo "<a href='product-details.php?sku=" . htmlspecialchars($row['sku']) . "'>";
            echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong></p>";
            echo "<p>SKU: " . htmlspecialchars($row['sku']) . "</p>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found.</p>";
    }
} else {
    echo "<p>Enter at least 3 characters to search.</p>";
}
?>
