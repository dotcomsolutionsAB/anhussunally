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
if (!isset($_GET['sku'])) {
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

// Fetch related products from the same brand
$brand = $product['brand'];
$relatedProductsQuery = "SELECT * FROM products WHERE brand = ? AND sku != ? LIMIT 4"; // Exclude the current product
$stmt = $conn->prepare($relatedProductsQuery);
$stmt->bind_param("ss", $brand, $sku);
$stmt->execute();
$relatedProductsResult = $stmt->get_result();

// $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="path/to/font-awesome.css"> <!-- Include Font Awesome -->
    <link rel="stylesheet" href="path/to/your-styles.css"> <!-- Include your CSS styles -->
</head>
<body>
    <!-- Existing Product Details Section -->
    <div class="product-details">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p><strong>SKU:</strong> <?php echo htmlspecialchars($product['sku']); ?></p>
        <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
        <div class="product-description">
            <h2>Description</h2>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="col-md-12">
        <h4 class="heading uppercase bottom30">Related Products</h4>
    </div>
    <div class="row">
        <?php while ($relatedProduct = $relatedProductsResult->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6">
                <div class="product_wrap bottom_half" style="padding-bottom: 0px; padding: 5px; border: 4px solid grey;">
                    <div class="tag-btn"><span class="uppercase text-center">New</span></div>
                    <div class="image">
                        <?php
                        // Get the first image from the images column
                        $imageIds = explode(',', $relatedProduct['images']);
                        $firstImageId = $imageIds[0];
                        $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                        $imageResult = $conn->query($imageQuery);
                        $image = $imageResult->fetch_assoc();
                        $imageLink = $image ? "api/uploads/assets/" . $image['file_original_name'] : "path/to/default-image.jpg";
                        ?>
                        <a href="api/product_details.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                            <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>" class="img-responsive">
                        </a>
                    </div>
                    <a href="api/product_details.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>" class="fancybox">
                        <div class="product_desc">
                            <p class="title"><?php echo htmlspecialchars($relatedProduct['name']); ?></p>
                            <span class="brand"><?php echo htmlspecialchars($relatedProduct['brand']); ?></span>
                            <span class="brand"><?php echo htmlspecialchars($relatedProduct['category']); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
