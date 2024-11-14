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

// Fetch all products from the products table
$productQuery = "SELECT sku, name, brand, category, images FROM products";
$result = $conn->query($productQuery);

if ($result->num_rows === 0) {
    echo "No products found.";
    $conn->close();
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Grid</title>
    <link rel="stylesheet" href="path/to/font-awesome.css"> <!-- Include Font Awesome -->
    <link rel="stylesheet" href="path/to/your-styles.css"> <!-- Include your CSS styles -->
    <style>
        .product_wrap {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .product_wrap:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .image img {
            max-width: 100%;
            height: auto;
        }
        .product_desc {
            margin-top: 10px;
        }
        .price {
            font-weight: bold;
            color: #333;
        }
        .tag-btn {
            background-color: #ff5a5f;
            color: #fff;
            padding: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    <div class="row">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6">
                <div class="product_wrap bottom_half">
                    <div class="tag-btn"><span class="uppercase text-center">New</span></div>
                    <div class="image">
                        <?php
                        // Get the first image from the images column
                        $imageIds = explode(',', $product['images']);
                        $firstImageId = $imageIds[0];
                        $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                        $imageResult = $conn->query($imageQuery);
                        $image = $imageResult->fetch_assoc();
                        $imageLink = $image ? "https://anh.ongoingwp.xyz/api/uploads/assets/" . $image['file_original_name'] : "path/to/default-image.jpg";
                        ?>
                        <a href="product_details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>">
                            <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-responsive">
                        </a>
                    </div>
                    <div class="product_desc">
                        <p class="title"><?php echo htmlspecialchars($product['name']); ?></p>
                        <span class="price"><i class="fa fa-gbp"></i>170.00</span> <!-- Adjust price display as needed -->
                        <a href="product_details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="fancybox"><i class="fa fa-shopping-bag open"></i></a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
