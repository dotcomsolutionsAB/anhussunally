<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("connection/db_connect.php");

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch parent categories for the selected brand
    $categories = [];
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $brand_id = intval($_GET['id']); // Ensure it's an integer

        // Modify query to include parent categories even if they have no child categories
        $categoryQuery = "
            SELECT DISTINCT c.id, c.name
            FROM categories c
            LEFT JOIN categories child ON child.parent_id = c.id
            LEFT JOIN products p ON p.category_id = child.id OR p.category_id = c.id
            WHERE c.parent_id = 0 AND p.brand_id = $brand_id";
        
        $categoryResult = $conn->query($categoryQuery);

        if ($categoryResult->num_rows > 0) {
            while ($row = $categoryResult->fetch_assoc()) {
                $categories[] = $row;
            }
        }
    } else {
        echo "<div class='alert alert-warning'>No brand ID provided. Please select a brand to view products.</div>";
    }                                                   

    // Fetch products by child categories under the selected parent category
    $products = [];
    $childCategoryNames = [];

    // Check if category_id is set and valid
    if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
        $category_id = intval($_GET['category_id']); // Ensure category_id is an integer

        // Fetch child categories of the selected parent category
        $childCategoriesQuery = "SELECT id FROM categories WHERE parent_id = $category_id";
        $childCategoriesResult = $conn->query($childCategoriesQuery);
        $childCategoryIds = [];

        if ($childCategoriesResult->num_rows > 0) {
            // If there are child categories, store their IDs
            while ($row = $childCategoriesResult->fetch_assoc()) {
                $childCategoryIds[] = $row['id'];
            }

            // Fetch products for these child categories
            if (!empty($childCategoryIds)) {
                $childCategoryIdsStr = implode(',', $childCategoryIds);

                // Fetch products for the child categories
                $productQuery = "
                    SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                    FROM products
                    LEFT JOIN brand ON products.brand_id = brand.id
                    WHERE products.category_id IN ($childCategoryIdsStr)";
                
                $productResult = $conn->query($productQuery);

                if ($productResult && $productResult->num_rows > 0) {
                    while ($row = $productResult->fetch_assoc()) {
                        $products[] = $row;
                    }
                }

                // Fetch child category names for display
                $childCategoryQuery = "SELECT id, name FROM categories WHERE id IN ($childCategoryIdsStr)";
                $childCategoryResult = $conn->query($childCategoryQuery);
                if ($childCategoryResult->num_rows > 0) {
                    while ($row = $childCategoryResult->fetch_assoc()) {
                        $childCategoryNames[$row['id']] = $row['name'];
                    }
                }
            }
        }

        // If there are no child categories, fetch products directly from the parent category
        if (empty($childCategoryIds)) {
            $productQuery = "
                SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                FROM products
                LEFT JOIN brand ON products.brand_id = brand.id
                WHERE products.category_id = $category_id";

            $productResult = $conn->query($productQuery);

            if ($productResult && $productResult->num_rows > 0) {
                while ($row = $productResult->fetch_assoc()) {
                    $products[] = $row;
                }
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
    <meta name="description" content="Renova - Construction Building & Renovation Template">
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
    <!-- header-area -->
    <?php include("inc_files/header.php"); ?>
    <!-- header-area-end -->

    <main class="main-area fix">
        <section class="shop__area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-xl-9 col-lg-8 order-0 order-lg-2">
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
                                foreach ($products as $product) { ?>
                                    <div class="col-xl-3 col-sm-6">
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
                                                <img src='<?php echo $imageLink; ?>' alt='<?php echo htmlspecialchars($product['name']); ?>'>
                                                <a href='product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>' class='btn view-details-btn'>View Details</a>
                                            </div>
                                            <div class='shop__content'>
                                                <h4 class='title'>
                                                    <a href='product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>'>
                                                        <?php echo htmlspecialchars($product['name']); ?>
                                                    </a>
                                                </h4>
                                                <p class='category-name'>Brand: <?php echo htmlspecialchars($product['brand_name']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                echo "<div class='alert alert-info'>No products found for the selected category and brand.</div>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4">
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
                    </div>
                </div>
            </div>
        </section>

        <!-- cta-area -->
        <section class="cta__area fix">
            <div class="cta__bg" data-background="assets/img/new/imggg3.jpg"></div>
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="cta__content">
                            <h2 class="title">Ready to work with <br> our team?</h2>
                            <div class="cta__btn">
                                <a href="contact.php" class="btn btn-two">Let’s build together <img
                                        src="assets/img/icons/right_arrow.svg" alt="" class="injectable"></a>
                                <a href="contact.php" class="btn transparent-btn">Contact With Us <img
                                        src="assets/img/icons/right_arrow.svg" alt="" class="injectable"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cta__content-right" data-aos="fade-up" data-aos-delay="600">
                            <h4 class="title">Leading Developer Of Commercial & Residential Projects</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cta__shape">
                <img src="assets/img/images/cta_shape.png" alt="shape" data-aos="fade-down-left" data-aos-delay="400">
            </div>
        </section>
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
