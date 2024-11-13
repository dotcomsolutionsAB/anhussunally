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

// Check if the SKU is provided in the URL
if (!isset($_GET['SDS180'])) {
    die("No SKU provided.");
}

$sku = $_GET['sku'];

// Fetch product details from the products table
$productQuery = "SELECT * FROM products WHERE sku = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("s", $sku);
$stmt->execute();
$productResult = $stmt->get_result();

if ($productResult->num_rows === 0) {
    die("Product not found.");
}

$product = $productResult->fetch_assoc();
$stmt->close();

// Fetch images from the upload table based on the image IDs in the images column
$imageIds = explode(',', $product['images']);
$images = [];

if (!empty($imageIds)) {
    $placeholders = implode(',', array_fill(0, count($imageIds), '?'));
    $imageQuery = "SELECT * FROM upload WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($imageQuery);
    $stmt->bind_param(str_repeat('i', count($imageIds)), ...array_map('intval', $imageIds));
    $stmt->execute();
    $imageResult = $stmt->get_result();
    
    while ($image = $imageResult->fetch_assoc()) {
        $images[] = $image['image_link'];
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <style>
        .product-details {
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }
        .product-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .product-images img {
            max-width: 100%;
            margin: 10px 0;
        }
        .product-description {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="product-details">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p><strong>SKU:</strong> <?php echo htmlspecialchars($product['sku']); ?></p>
        <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>

        <div class="product-images">
            <h2>Images</h2>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $imageLink): ?>
                    <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="Product Image">
                <?php endforeach; ?>
            <?php else: ?>
                <p>No images available.</p>
            <?php endif; ?>
        </div>

        <div class="product-description">
            <h2>Description</h2>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>
    </div>
</body>
</html>
