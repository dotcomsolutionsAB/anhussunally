<?php
ini_set('display_errors', 0);
// Include the database connection file
include(__DIR__ . '/../api/db_connection.php');

// Get the current page name dynamically
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Define a mapping for friendly breadcrumb labels, links, and optional dynamic titles
$breadcrumb_mapping = [
    'index' => ['label' => 'Home', 'link' => 'index.php'],
    'brands' => ['label' => 'Brand', 'link' => 'brands.php'],
    'product' => ['label' => 'Products', 'link' => 'products.php'],
    'categories' => ['label' => 'Categories', 'link' => 'categories.php'],
    'product_detail' => ['label' => 'Products', 'link' => 'product_detail.php'],
    'about_us' => ['label' => 'About Us', 'link' => 'about_us.php'],
];

$dynamic_label = '';
$dynamic_link = '';

// Fetch dynamic labels for specific pages
if ($current_page === 'brands' && isset($_GET['id']) && !empty($_GET['id'])) {
    $brandId = intval($_GET['id']);
    $brandQuery = "SELECT name FROM brand WHERE id = $brandId";
    $brandResult = $conn->query($brandQuery);

    if ($brandResult && $brandResult->num_rows > 0) {
        $brand = $brandResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($brand['name']);
        $dynamic_link = 'brands.php?id=' . urlencode($brandId);
    }
}

if ($current_page === 'categories' && isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    $categoryQuery = "SELECT name FROM categories WHERE id = $categoryId";
    $categoryResult = $conn->query($categoryQuery);

    if ($categoryResult && $categoryResult->num_rows > 0) {
        $category = $categoryResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($category['name']);
        $dynamic_link = 'categories.php?id=' . urlencode($categoryId);
    }
}

if ($current_page === 'product_detail' && isset($_GET['sku']) && !empty($_GET['sku'])) {
    $productSku = $_GET['sku'];
    $productQuery = "SELECT name FROM products WHERE sku = '$productSku'";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
        $dynamic_label = htmlspecialchars($product['name']);
        $dynamic_link = 'product_detail.php?sku=' . urlencode($productSku);
    }
}

$current_breadcrumb = $breadcrumb_mapping[$current_page] ?? ['label' => ucfirst(str_replace('_', ' ', $current_page)), 'link' => '#'];

if (!empty($dynamic_label) && $dynamic_label === $current_breadcrumb['label']) {
    $dynamic_label = '';
}
?>

<style>
    /* General Styling */
    /* Page Header Section */
    .random-header {
        background-image: url('https://anh.ongoingwp.xyz/images/page-header.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 20px 0;
        border-bottom: 1px solid #ddd;
    }

    /* Overlay */
    .random-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* Dark overlay */
        z-index: 1;
    }

    .random-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        position: relative;
        z-index: 2;
    }

    .random-header-content {
        text-align: center;
    }

    .random-header h1 {
        font-size: 28px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
        color: #fff;
    }

    .random-header p {
        font-size: 14px;
        color: #fff;
    }

    .random-header a {
        text-decoration: none;
        color: #007bff;
        transition: color 0.3s ease;
    }

    .random-header a:hover {
        color: #0056b3;
    }

    /* Breadcrumb Styling */
    .random-header p a {
        margin: 0 5px;
        font-weight: bold;
    }

    .random-header p a:last-child {
        color: #fff;
        pointer-events: none;
        font-weight: normal;
    }
    .random-uppercase a {
        color: #fff !important;
    }
    .random-bread a {
        color: #ccc !important;
    }
    .random-row {
        display: flex;
        justify-content: center;
    }
    @media (max-width: 480px) {
        .random-row {
            gap: 5vw;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            text-align: justify;
        }
    }
</style>

<section class="page_header padding">
    <div class="container">
        <div class="header_content padding">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <div class="col-md-12 text-center" style="width: max-content; display: flex; justify-content:center; align-items: center; flex-direction: column;">
                    <h1 class="uppercase">
                        <?php if (!empty($dynamic_label)): ?>
                            <a href="#"><?php echo $dynamic_label; ?></a>
                        <?php else: ?>
                            <a href="#"><?php echo $current_breadcrumb['label']; ?></a>
                        <?php endif; ?>
                    </h1>
                    <p class="bread">
                        <a href="<?php echo $breadcrumb_mapping['index']['link']; ?>">Home</a> /
                        <a href="<?php echo $current_breadcrumb['link']; ?>"><?php echo $current_breadcrumb['label']; ?></a>
                        <?php if (!empty($dynamic_label)): ?>
                            <a href="#"><?php echo $dynamic_label; ?></a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

