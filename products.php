<?php
include("connection/db_connect.php");

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
    // Fetch products by brand
    $productQuery = "SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                     FROM products
                     LEFT JOIN brand ON products.brand_id = brand.id
                     WHERE products.brand_id = $brand_id";
    $result = $conn->query($productQuery);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
}

// Fetch products for selected category
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $categoryProductQuery = "SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                             FROM products
                             LEFT JOIN brand ON products.brand_id = brand.id
                             WHERE products.category_id = $category_id";
    $categoryResult = $conn->query($categoryProductQuery);
    if ($categoryResult->num_rows > 0) {
        while($row = $categoryResult->fetch_assoc()) {
            $products[] = $row;
        }
    }
}

$conn->close();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!--Preloader-->
    <!-- <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="assets/img/logo/preloader.svg" alt="Preloader"></div>
            </div>
        </div>
    </div> -->
    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="renova-up-arrow"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
        <?php include("inc_files/header.php"); ?>
    <!-- header-area-end -->



    <!-- main-area -->
    <main class="main-area fix">

        <!-- breadcrumb-area -->
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
        <!-- breadcrumb-area-end -->

        <!-- shop-area -->
        <section class="shop__area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-xl-9 col-lg-8 order-0 order-lg-2">
                        <div class="shop__top-wrap">
                            <!-- <div class="row gutter-24 align-items-center">
                                <div class="col-md-5">
                                    <div class="shop__showing-result">
                                        <p>Showing 1 - 12 of 30 Results</p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="shop__ordering">
                                        <select name="orderby" class="orderby">
                                            <option value="Short by Category">Select Category</option>
                                            <option value="Sort by popularity">Sort by popularity</option>
                                            <option value="Sort by average rating">Sort by average rating</option>
                                            <option value="Sort by latest">Sort by latest</option>
                                            <option value="Sort by latest">Sort by latest</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row gutter-24 align-items-center">
                                <div class="col-md-5">
                                    <div class="shop__showing-result">
                                        <p>Showing 1 - 12 of 30 Results</p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="shop__ordering">
                                        <select name="orderby" class="orderby">
                                            <option value="Select Category">Select Category</option>
                                                <?php
                                                    foreach ($categories as $category) {
                                                        echo "<option value='{$category['id']}'>{$category['name']} ({$category['product_count']} products)</option>";
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gutter-24">

                            <?php while ($product = $result->fetch_assoc()): ?>
    <div class="col-xl-4 col-sm-6">
        <div class="shop__item">
            <div class="shop__thumb">
                <?php
                    // Image handling: If no images, use a default one
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
                                $imageLink = "images/default.png"; // Use default image if image is missing
                            }
                        } else {
                            $imageLink = "images/default.png"; // Use default image if no image IDs
                        }
                    } else {
                        $imageLink = "images/default.png"; // Use default image if no image is provided
                    }
                ?>
                <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <a href="product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="btn view-details-btn">View Details</a>
                <?php if ($product['hours_since_creation'] <= 24): ?>
                    <span class="sticker new-product-sticker">NEW</span>
                <?php endif; ?>
            </div>
            <div class="shop__content">
                <?php if (!empty($product['price'])): ?>
                    <h6 class="price"><?php echo htmlspecialchars($product['price']); ?></h6>
                <?php else: ?>
                    <h6 class="price">Price not available</h6>
                <?php endif; ?>

                <h4 class="title">
                    <a href="product-details.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="product-title">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </a>
                </h4>

                <?php if (!empty($product['rating'])): ?>
                    <div class="rating">
                        <?php 
                            // Display stars for ratings (Assuming a rating out of 5)
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $product['rating']) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                }
                            }
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']): ?>
                    <span class="badge sale-badge">Sale</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>


                            <!-- <div class="col-xl-4 col-sm-6">
                                <div class="shop__item">
                                    <div class="shop__thumb">
                                        <img src="assets/img/product/shop_img12.png" alt="img">
                                        <a href="shop-details.html" class="btn">Add To Cart</a>
                                    </div>
                                    <div class="shop__content">
                                        <h6 class="price">$180.00</h6>
                                        <h4 class="title"><a href="shop-details.html">Fiber Cement Siding</a></h4>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
                                        <?php while ($brand = $resultBrand->fetch_assoc()): ?>
                                            <li>
                                                <a href="brands.php?id=<?php echo intval($brand['id']); ?>">
                                                    <?= htmlspecialchars($brand['name']); ?> 
                                                    <i class="renova-right-arrow"></i>
                                                </a>
                                            </li>
                                            <!-- 
                                            <li>
                                                <a href="blog.html">Battery Charge <i class="renova-right-arrow"></i></a>
                                            </li> -->
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="blog__widget shop__widget">
                                <h4 class="blog__widget-title">Filter By Price</h4>
                                <div class="price_filter">
                                    <div id="slider-range"></div>
                                    <div class="price_slider_amount">
                                        <input type="text" id="amount" name="price" placeholder="Add Your Price">
                                    </div>
                                </div>
                            </div>

                            <div class="blog__widget shop__widget">
                                <h4 class="blog__widget-title">Popular Product</h4>
                                <div class="popular__product-wrap">
                                    <div class="popular__product-item">
                                        <div class="thumb">
                                            <a href="shop-details.html"><img src="assets/img/product/popular_product01.jpg" alt="img"></a>
                                        </div>
                                        <div class="content">
                                            <span class="price">$250.00</span>
                                            <h4 class="title"><a href="shop-details.html">Brick Veneer Topis</a></h4>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog__widget shop__widget">
                                <h4 class="blog__widget-title">Popular Tags</h4>
                                <div class="blog__tag-list">
                                    <ul class="list-wrap">
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Business</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>

                </div>
            </div>
        </section>
        <!-- shop-area-end -->

        <!-- cta-area -->
        <section class="cta__area fix">
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
        </section>
        <!-- cta-area-end -->

    </main>
    <!-- main-area-end -->

    <!-- footer-area -->
    <?php include("inc_files/footer.php"); ?>
    <!-- footer-area-end -->


    <script>
        $(document).ready(function () {
            // Function to fetch and display products based on selected brand and category
            function loadProducts() {
                let brandId = $('#brandSelect').val();
                let categoryId = $('#categorySelect').val();

                $.ajax({
                    url: 'your_php_file.php', // Make sure this points to the correct PHP file
                    type: 'GET',
                    data: {
                        brand_id: brandId,
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('#productList').html(response);
                    }
                });
            }

            // Trigger product loading when brand is selected
            $('#brandSelect').change(function () {
                loadProducts();
            });

            // Trigger product loading when category is selected
            $('#categorySelect').change(function () {
                loadProducts();
            });
        });
    </script>

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
<?php
// If products are fetched for a particular brand or category, output them
if (!empty($products)) {
    echo "<div class='product-section'>";
    foreach ($products as $product) {
        echo "<div class='product'>
                <h3>{$product['name']}</h3>
                <p>Brand: {$product['brand_name']}</p>
                <p>Created {$product['hours_since_creation']} hours ago</p>
              </div>";
    }
    echo "</div>";
} else {
    echo "<p>No products found for the selected brand/category.</p>";
}
?>
