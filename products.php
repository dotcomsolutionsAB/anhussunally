<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connection/db_connect.php");
$host = 'localhost';
$dbname = 'anh';
$username = 'anh';
$password = '9kCuzrb5tO53$xQtf';
// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product count for each category
$query = "SELECT c.id, c.name, COUNT(p.id) AS product_count
          FROM categories c
          LEFT JOIN products p ON p.category_id = c.id
          GROUP BY c.id";
$categoryResult = $conn->query($query);
$categories = [];
if ($categoryResult->num_rows > 0) {
    while($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch all brands
$brandQuery = "SELECT * FROM brand";
$brandResult = $conn->query($brandQuery);
$brands = [];
if ($brandResult->num_rows > 0) {
    while($row = $brandResult->fetch_assoc()) {
        $brands[] = $row;
    }
}

// Fetch products for selected brand and category
$products = [];


if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

    // Fetch categories that have products under the selected brand
    $categoryQuery = "SELECT DISTINCT c.id, c.name
                      FROM categories c
                      INNER JOIN products p ON p.category_id = c.id
                      WHERE p.brand_id = $brand_id";
    $categoryResult = $conn->query($categoryQuery);
    $categories = [];
    if ($categoryResult->num_rows > 0) {
        while ($row = $categoryResult->fetch_assoc()) {
            $categories[] = $row;
        }
    }
}


// Fetch products by category
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $categoryProductQuery = "SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                             FROM products
                             LEFT JOIN brand ON products.brand_id = brand.id
                             WHERE products.category_id = $category_id";
    $categoryProductResult = $conn->query($categoryProductQuery);
    if ($categoryProductResult->num_rows > 0) {
        while($row = $categoryProductResult->fetch_assoc()) {
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
    <!--Preloader-->
    <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="assets/img/logo/preloader.svg" alt="Preloader"></div>
            </div>
        </div>
    </div>
    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="renova-up-arrow"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
    <?php include("inc_files/header.php"); ?>
    <!-- header-area-end -->

    <main class="main-area fix">
        <div class="breadcrumb__area breadcrumb__bg" data-background="images/page-header.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__content">
                            <h2 class="title">Our Store</h2>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="index.html">Home</a>
                                </span>
                                <span class="breadcrumb-separator">/</span>
                                <span property="itemListElement" typeof="ListItem">Our Store</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="shop__area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-xl-9 col-lg-8 order-0 order-lg-2">
                        <div class="shop__top-wrap">
                            <div class="row gutter-24 align-items-center">
                                <div class="col-md-5">
                                    <div class="shop__showing-result">
                                        <p>Showing 1 - 12 of 30 Results</p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="shop__ordering">
                                        <select name="category_id" class="orderby" onchange="window.location.href=this.value;">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                echo "<option value='?category_id={$category['id']}'>{$category['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                            <div class="row gutter-24">
                                <?php
                                    if (isset($_GET['brand_id'])) {
                                        $brand_id = $_GET['brand_id'];

                                        // Loop through each category and show products for that brand
                                        foreach ($categories as $category) {
                                            // Fetch products for the current category and brand
                                            $categoryProductQuery = "SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                                                                FROM products
                                                                LEFT JOIN brand ON products.brand_id = brand.id
                                                                WHERE products.category_id = {$category['id']} AND products.brand_id = $brand_id";
                                            $categoryProductResult = $conn->query($categoryProductQuery);

                                            // Check if products are found and display them
                                            if ($categoryProductResult->num_rows > 0) { ?>
                                                <div class='col-12'>
                                                    <div class="shop__top-wrap">
                                                        <div class="row gutter-24 align-items-center">
                                                            <div class="col-md-12">
                                                                <div class="shop__showing-result">
                                                                    <h4><?php echo $category['name']; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <h4></h4> -->
                                                    <div class='row gutter-24'>
                                            
                                                        <?php while ($product = $categoryProductResult->fetch_assoc()) { ?>
                                                                <div class='col-xl-3 col-sm-6'>
                                                                    <div class='shop__item'>
                                                                        <div class='shop__thumb'>
                                                                        <?php
                                                                            if (!empty($product['images']) && $product['images'] != '') {
                                                                                $imageIds = explode(',', $product['images']);
                                                                                $firstImageId = $imageIds[0] ?? null;

                                                                                if ($firstImageId) {
                                                                                    $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                                                                                    $imageResult = $conn->query($imageQuery);
                                                                                    if ($imageResult && $imageResult->num_rows > 0) {
                                                                                        $image = $imageResult->fetch_assoc();
                                                                                        $imageLink = "uploads/assets/" . $image['file_original_name'];
                                                                                    } else {
                                                                                        $imageLink = "images/default.png"; 
                                                                                    }
                                                                                } else {
                                                                                    $imageLink = "images/default.png"; 
                                                                                }
                                                                            } else {
                                                                                $imageLink = "images/default.png"; 
                                                                            }
                                                                        ?>
                                                                            <img src='<?php echo htmlspecialchars($imageLink); ?>' alt='<?php echo $product['name']; ?>'>
                                                                            <a href='product-details.php?sku=<?php echo $product['sku']; ?>' class='btn view-details-btn'>View Details</a>
                                                                        </div>
                                                                        <div class='shop__content'>
                                                                            <h4 class='title'>
                                                                                <a href='product-details.php?sku=<?php echo $product['sku']; ?>' class='product-title'>
                                                                                    <?php echo strlen($product['name']) > 24 ? htmlspecialchars(substr($product['name'], 0, 24)) . '...' : htmlspecialchars($product['name']); ?>
                                                                                </a>
                                                                            </h4>
                                                                            <p class='category-name'>Brand: <?php echo $product['brand_name']; ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } 
                                        }
                                    }
                                ?>
                            </div>
                    </div>

                    <!-- Side Section -->
                    <div class="col-xl-3 col-lg-4">
                        <aside class="shop__sidebar">
                            <div class="blog__widget">
                                <div class="blog__search">
                                    <form action="#" class="blog__search-form">
                                        <input type="text" placeholder="Enter Keyword">
                                        <button type="submit"><i class="renova-search-2"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="blog__widget">
                                <h4 class="blog__widget-title">Brands</h4>
                                <div class="blog__cat-list shop__cat-list">
                                    <ul class="list-wrap">
                                        <?php 
                                        $brandQuery = "SELECT * FROM brand";
                                        $brandResult = $conn->query($brandQuery);

                                        if ($brandResult->num_rows > 0) {
                                            while ($brand = $brandResult->fetch_assoc()) {
                                                echo '<li><a href="?brand_id=' . $brand['id'] . '">' . htmlspecialchars($brand['name']) . '</a></li>';
                                            }
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
        <!-- <section class="cta__area fix">
            <div class="cta__bg" data-background="assets/img/bg/cta_bg.jpg"></div>
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="cta__content">
                            <h2 class="title">Ready to work with <br> our team?</h2>
                            <div class="cta__btn">
                                <a href="contact.html" class="btn btn-two">Let’s build together <img
                                        src="assets/img/icons/right_arrow.svg" alt="" class="injectable"></a>
                                <a href="contact.html" class="btn transparent-btn">Contact With Us <img
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
        </section> -->
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
