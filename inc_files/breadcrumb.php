<?php
    ini_set('display_errors', 0);
    // Include the database connection file
    include(__DIR__ . '../connection/db_connect.php');

    // Get the current page name dynamically
    $current_page = basename($_SERVER['PHP_SELF'], ".php");

    // Define a mapping for friendly breadcrumb labels, links, and optional dynamic titles
    $breadcrumb_mapping = [
        'index' => ['label' => 'Home', 'link' => 'index.php'],
        'brand-products.php' => ['label' => 'Brand-products', 'link' => 'brand-products.php'],
        'products' => ['label' => 'Products', 'link' => 'products.php'],
        'categories' => ['label' => 'Categories', 'link' => 'categories.php'],
        'product_details' => ['label' => 'Product-details', 'link' => 'product_details.php'],
        'brand_details' => ['label' => 'Brand-details', 'link' => 'brand_details.php'],
        'category_details' => ['label' => 'Category-details', 'link' => 'category_details.php'],
        'about_us' => ['label' => 'About Us', 'link' => 'about_us.php'],
    ];

   
    $dynamic_label = '';
    $dynamic_link = '';

    // Fetch dynamic labels for specific pages
    if ($current_page === 'brand-products' && isset($_GET['id']) && !empty($_GET['id'])) {
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

    if ($current_page === 'product-details' && isset($_GET['sku']) && !empty($_GET['sku'])) {
        $productSku = $_GET['sku'];
        $productQuery = "SELECT name FROM products WHERE sku = '$productSku'";
        $productResult = $conn->query($productQuery);

        if ($productResult && $productResult->num_rows > 0) {
            $product = $productResult->fetch_assoc();
            $dynamic_label = htmlspecialchars($product['name']);
            $dynamic_link = 'product_details.php?sku=' . urlencode($productSku);
        }
    }

    $current_breadcrumb = $breadcrumb_mapping[$current_page] ?? ['label' => ucfirst(str_replace('_', ' ', $current_page)), 'link' => '#'];

    if (!empty($dynamic_label) && $dynamic_label === $current_breadcrumb['label']) {
        $dynamic_label = '';
    }   
?>

<div class="breadcrumb__area breadcrumb__bg" data-background="images/page-header.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__content">
                    <!-- <h2 class="title">About Us</h2> -->
                    <h2 class="title">
                        <?php if (!empty($dynamic_label)): ?>
                            <a href="#"><?php echo $dynamic_label; ?></a>
                        <?php else: ?>
                            <a href="#"><?php echo $current_breadcrumb['label']; ?></a>
                        <?php endif; ?>
                    </h2>
                    <nav class="breadcrumb">
                        <span property="itemListElement" typeof="ListItem">
                            <a href="<?php echo $breadcrumb_mapping['index']['link']; ?>">Home</a>
                        </span>
                        
                        <?php if($current_breadcrumb['label']=="Brand"){ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>" style="display:block;">/ <?php echo $current_breadcrumb['label']; ?></a>
                        
                            <?php }else if($current_breadcrumb['label']=="Products"){ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>" style="display:block;">/ <?php echo $current_breadcrumb['label']; ?></a>
                        
                            <?php }else if($current_breadcrumb['label']=="Categories"){ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>" style="display:block;">/ <?php echo $current_breadcrumb['label']; ?></a>
                        
                            <?php }else if($current_breadcrumb['label']=="Product-details"){ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>" style="display:none;">/ <?php echo $current_breadcrumb['label']; ?></a>
                            
                            <?php }else if($current_breadcrumb['label']=="Brand-products"){ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>" style="display:none;">/ <?php echo $current_breadcrumb['label']; ?></a>

                            <?php }else{ ?>
                            <a href="<?php echo $current_breadcrumb['link']; ?>">/ <?php echo $current_breadcrumb['label']; ?></a>
                        
                        <?php } ?>

                        <span property="itemListElement" typeof="ListItem">
                            <?php if (!empty($dynamic_label)): ?>
                                <a href="#">/ <?php echo $dynamic_label; ?></a>
                            <?php endif; ?>
                        </span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>