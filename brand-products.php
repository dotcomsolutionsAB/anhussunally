<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connection/db_connect.php");

// Fetch parent categories for the selected brand
$categories = [];
$selectedCategoryId = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $brand_id = intval($_GET['id']); // Ensure it's an integer

    // Fetch parent categories for the selected brand
    $categoryQuery = "
        SELECT DISTINCT c.id, c.name
        FROM categories c
        LEFT JOIN categories child ON child.parent_id = c.id
        LEFT JOIN products p ON (p.category_id = c.id OR p.category_id = child.id)
        WHERE c.parent_id = 0 AND p.brand_id = $brand_id
        ORDER BY c.id ASC"; // Ensure consistent ordering of parent categories

    $categoryResult = $conn->query($categoryQuery);

    if ($categoryResult->num_rows > 0) {
        while ($row = $categoryResult->fetch_assoc()) {
            $categories[] = $row;
        }

        // Auto-select the first parent category
        if (!isset($_GET['category_id']) && count($categories) > 0) {
            $selectedCategoryId = $categories[0]['id']; // Default to the first parent category
        } else {
            $selectedCategoryId = intval($_GET['category_id']);
        }
    }
}

// Fetch products based on the selected category
$products = [];
$childCategoryNames = [];

if ($selectedCategoryId) {
    // Fetch child categories for the selected parent category
    $childCategoriesQuery = "SELECT id, name FROM categories WHERE parent_id = $selectedCategoryId";
    $childCategoriesResult = $conn->query($childCategoriesQuery);
    $childCategoryIds = [];

    if ($childCategoriesResult->num_rows > 0) {
        while ($row = $childCategoriesResult->fetch_assoc()) {
            $childCategoryIds[] = $row['id'];
            $childCategoryNames[$row['id']] = $row['name'];
        }
    }

    // Fetch products for child categories or parent category
    if (!empty($childCategoryIds)) {
        $childCategoryIdsStr = implode(',', $childCategoryIds);
        $productQuery = "
            SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
            FROM products
            LEFT JOIN brand ON products.brand_id = brand.id
            WHERE (products.category_id IN ($childCategoryIdsStr) OR products.category_id = $selectedCategoryId)
              AND products.brand_id = $brand_id";
    } else {
        $productQuery = "
            SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
            FROM products
            LEFT JOIN brand ON products.brand_id = brand.id
            WHERE products.category_id = $selectedCategoryId AND products.brand_id = $brand_id";
    }

    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        while ($row = $productResult->fetch_assoc()) {
            $products[] = $row;
        }
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AN Hussunally & Co</title>
    <meta name="description" content="AN Hussunally & Co">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default-icons.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/tg-cursor.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="images/favicon.png">
</head>
<body>
    <?php include("inc_files/header.php"); ?>
    
    <main class="main-area fix">
        <section class="shop__area section">
            <div class="breadcrumb__area breadcrumb__bg" data-background="images/page-header.jpg">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="blog__cat-list shop__cat-list">
                                <div class="abc">
                                    <style>
                                        .abc {
                                            display: flex;
                                            gap: 20px; /* Space between grid items */
                                            justify-content:center;
                                            align-items: center; /* Centers items vertically */
                                        }

                                        .abc div {
                                            background: #fff;
                                            padding: 15px 30px; /* Default padding */
                                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                                            text-align: center; /* Center content inside div */
                                            margin: 0px 10px;
                                        }

                                        .abc div:hover {
                                            transform: scale(1.1); /* Makes the div "pop" */
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow */
                                        }

                                        .abc div a {
                                            font-size: xx-large;
                                            font-weight: 900;
                                            text-decoration: none; /* Removes underline */
                                            color: black; /* Ensures default font color is black */
                                        }

                                        .abc div a:hover {
                                            color: var(--tg-theme-primary); /* Changes font color on hover */
                                        }

                                        /* Mobile-specific styles */
                                        @media (max-width: 520px) {
                                            .abc{
                                                display: grid;
                                                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Auto grid layout */
                                                gap: 10px; /* Space between grid items */
                                                justify-content:space-between;
                                            }
                                            .abc div {
                                                padding: 10px 15px; /* Mobile-specific padding */
                                                margin: 0px 10px;
                                            }

                                            .abc div a {
                                                font-size: large; /* Reduce font size for smaller screens */
                                            }
                                        }
                                    </style>
                                        <?php
    if (!empty($categories)) {
        // Display parent categories
        foreach ($categories as $category) {
            $isActive = ($category['id'] == $selectedCategoryId) ? 'style="font-weight:bold; color:var(--tg-theme-primary);"' : '';
            echo '<div><a href="?category_id=' . $category['id'] . '&id=' . $brand_id . '" ' . $isActive . '>'
                 . htmlspecialchars($category['name']) . '</a></div>';
        }
    } else {
        echo '<div>No categories found for this brand.</div>';
    }
    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>

            <div class="container">
                <div class="row gutter-24">
                    <div class="col-xl-12 col-lg-8 order-0 order-lg-2">
                        <div class="shop__top-wrap">
                            <div class="row gutter-24 align-items-center">
                                <div class="col-md-5">
                                    <div class="shop__showing-result">
                                        <p>Showing <?php echo count($products); ?> Results</p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="shop__ordering">
                                        <select name="category_id" class="orderby" onchange="window.location.href=this.value;">
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category) { ?>
                                                <option value="?category_id=<?php echo $category['id']; ?>&id=<?php echo $brand_id; ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gutter-24">
                            <?php
                            if (!empty($products)) {
                                if (!empty($childCategoryNames)) {
                                    foreach ($childCategoryNames as $childCategoryId => $childCategoryName) {
                                        echo "<h3>" . htmlspecialchars($childCategoryName) . "</h3>";
                                        echo '<div class="row gutter-24">';
                                        foreach ($products as $product) {
                                            if ($product['category_id'] == $childCategoryId) { ?>
                                                <div class="col-6 col-md-3">
                                                    <!-- col-6 col-md-3 use this for mobile 2 grid and desktop 4 grid -->
                                                    <div class="shop__item">
                                                        <div class="shop__thumb">
                                                        <?php
                                                            // Fetch the first product image
                                                            $imageLink = "images/default.png"; // Default image
                                                            if (!empty($product['images']) && $product['images'] != '') {
                                                                $imageIds = explode(',', ltrim($product['images'], ',')); // Remove leading comma if present
                                                                $firstImageId = $imageIds[0] ?? null;

                                                                if ($firstImageId) {
                                                                    $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                                                                    $imageResult = $conn->query($imageQuery);
                                                                    if ($imageResult && $imageResult->num_rows > 0) {
                                                                        $image = $imageResult->fetch_assoc();
                                                                        $imageLink = "uploads/assets/" . $image['file_original_name'];
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                        <img src="<?php echo $imageLink; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" >
                                                            <a href="product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="btn">View Details</a>
                                                        </div>
                                                        <div class='shop__content'>
                                                            <h4 class='title'>
                                                                <a href='product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>'>
                                                                <?php echo strlen($product['name']) > 24 ? htmlspecialchars(substr($product['name'], 0, 24)) . '...' : htmlspecialchars($product['name']); ?>
                                                                </a>
                                                            </h4>
                                                            <p class='category-name' style="margin-bottom: 0px;">Brand: <?php echo htmlspecialchars($product['brand_name']); ?></p>
                                                            <p class='category-name' style="margin-bottom: 0px;">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
                                                        </div>        
                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                        echo '</div>';
                                    }
                                } else {
                                    echo "<h3>Same as Selected Category</h3>";
                                    foreach ($products as $product) { ?>
                                        <div class="col-6 col-md-3">
                                        <!-- <div class="col-xl-3 col-sm-6"> original code  -->
                                            <!-- col-6 col-md-3 use this for mobile 2 grid and desktop 4 grid -->
                                            <div class="shop__item">
                                                <div class="shop__thumb">
                                                    <?php
                                                        // Fetch the first product image
                                                        $imageLink = "images/default.png"; // Default image
                                                        if (!empty($product['images']) && $product['images'] != '') {
                                                            $imageIds = explode(',', ltrim($product['images'], ',')); // Remove leading comma if present
                                                            $firstImageId = $imageIds[0] ?? null;

                                                            if ($firstImageId) {
                                                                $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                                                                $imageResult = $conn->query($imageQuery);
                                                                if ($imageResult && $imageResult->num_rows > 0) {
                                                                    $image = $imageResult->fetch_assoc();
                                                                    $imageLink = "uploads/assets/" . $image['file_original_name'];
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <img src="<?php echo $imageLink; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 200px; object-fit: contain;">
                                                    <a href="product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="btn">View Details</a>
                                                </div>
                                                <div class='shop__content'>
                                                    <h4 class='title'>
                                                        <a href='product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>'>
                                                            <?php echo strlen($product['name']) > 24 ? htmlspecialchars(substr($product['name'], 0, 24)) . '...' : htmlspecialchars($product['name']); ?>
                                                        </a>
                                                    </h4>
                                                    <p class='category-name'>Brand: <?php echo htmlspecialchars($product['brand_name']); ?></p>
                                                    <p class='category-name'>SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            } else {
                                echo "<div class='alert alert-info'>Kindly Select the Category</div>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- <div class="col-xl-3 col-lg-4">
                        <aside class="shop__sidebar">
                            <div class="blog__widget">
                                <h4 class="blog__widget-title">Categories</h4>
                                <div class="blog__cat-list shop__cat-list">
                                    <ul class="list-wrap">
                                    <?php
                                        if (!empty($categories)) {
                                            foreach ($categories as $category) {
                                                echo '<li><a href="?category_id=' . $category['id'] . '&id=' . $brand_id . '">' . htmlspecialchars($category['name']) . '</a></li>';
                                            }
                                        } else {
                                            echo '<li>No categories found for this brand.</li>';
                                        }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div> -->
                </div>
            </div>
        </section>
        <!-- cta-area -->
            <?php include("inc_files/cta_area.php"); ?>
        <!-- cta-area-end -->
    </main>

    <?php include("inc_files/footer.php"); ?>
    <!-- Add jQuery to simplify AJAX calls (if not included already) -->
    
    <!-- JS here -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.odometer.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery.marquee.min.js"></script>
    <script src="assets/js/tg-cursor.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/svg-inject.min.js"></script>
    <script src="assets/js/tween-max.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        SVGInject(document.querySelectorAll("img.injectable"));
    </script>
</body>
</html>
