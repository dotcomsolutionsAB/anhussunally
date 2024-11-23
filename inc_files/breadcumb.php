<?php
// Include the database connection file
include(__DIR__ . '/../api/db_connection.php');

// Get the current page name dynamically
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Define a mapping for friendly breadcrumb labels and links
$breadcrumb_mapping = [
    'index' => ['label' => 'Home', 'link' => 'index.php'],
    'brands' => ['label' => 'Brand', 'link' => 'brands.php'], // General brands page
    'product' => ['label' => 'Products', 'link' => 'products.php'], // General products page
    'categories' => ['label' => 'Categories', 'link' => 'categories.php'], // General categories page
    'product_detail' => ['label' => 'Products', 'link' => 'product_detail.php'], // General products page
];

// Placeholder for additional dynamic context (e.g., brand, category, product name)
$dynamic_label = '';
$dynamic_link = '';

// Check if it's a brand page with a specific brand ID in the URL
if ($current_page === 'brands' && isset($_GET['id']) && !empty($_GET['id'])) {
    $brandId = intval($_GET['id']); // Sanitize brand_id
    $brandQuery = "SELECT name FROM brand WHERE id = $brandId";
    $brandResult = $conn->query($brandQuery);

    if ($brandResult && $brandResult->num_rows > 0) {
        $brand = $brandResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($brand['name']); // Sanitize the brand name
        $dynamic_link = 'brands.php?id=' . urlencode($brandId); // Generate link
    }
}

// Check if it's a category page with a specific category ID in the URL
if ($current_page === 'categories' && isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryId = intval($_GET['id']); // Sanitize category_id
    $categoryQuery = "SELECT name FROM categories WHERE id = $categoryId";
    $categoryResult = $conn->query($categoryQuery);

    if ($categoryResult && $categoryResult->num_rows > 0) {
        $category = $categoryResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($category['name']); // Sanitize the category name
        $dynamic_link = 'categories.php?id=' . urlencode($categoryId); // Generate link
    }
}

// Check if it's a product page with a specific product ID in the URL
if ($current_page === 'product_detail' && isset($_GET['sku']) && !empty($_GET['sku'])) {
    $productSku = intval($_GET['sku']); // Sanitize product_id
    $productQuery = "SELECT name FROM products WHERE sku = $productSku";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($product['name']); // Sanitize the product name
        $dynamic_link = 'product_detail.php?sku=' . urlencode($productSku); // Generate link
    }
}

// Get the breadcrumb for the current page
$current_breadcrumb = $breadcrumb_mapping[$current_page] ?? ['label' => ucfirst($current_page), 'link' => '#'];

?>

<section class="page_header padding">
    <div class="container">
        <div class="header_content padding">
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-12 text-center" style="width: max-content; display: flex; justify-content: flex-start; align-items: flex-start; flex-direction: column;">
                    <h1 class="uppercase">
                        <?php if (!empty($dynamic_label)): ?>
                            <a href="#"><?php echo $dynamic_label; ?></a>
                        <?php endif; ?>
                    </h1>
                    <p>
                        <a href="<?php echo $breadcrumb_mapping['index']['link']; ?>">Home</a> /
                        <!-- <a href="<?php echo $current_breadcrumb['link']; ?>"><?php echo $current_breadcrumb['label']; ?></a> -->
                        <a href="products.php"><?php echo $current_breadcrumb['label']; ?></a>
                        <?php if (!empty($dynamic_label)): ?>
                            / <a href="<?php echo $dynamic_link; ?>"><?php echo $dynamic_label; ?></a>
                        <?php endif; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
