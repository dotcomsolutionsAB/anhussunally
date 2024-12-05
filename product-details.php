<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    include("connection/db_connect.php");
    // Establish database connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>
<?php
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
    $brand = $product['brand_id'];
    $relatedProductsQuery = "SELECT *, TIMESTAMPDIFF(HOUR, created_at, NOW()) AS hours_since_creation FROM products WHERE brand_id = ? AND sku != ? LIMIT 4"; // Exclude the current product
    $stmt = $conn->prepare($relatedProductsQuery);
    $stmt->bind_param("ss", $brand, $sku);
    $stmt->execute();
    $relatedProductsResult = $stmt->get_result();

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $product['name']; ?></title>
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
                            <h2 class="title">Product Details</h2>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="index.html">Home</a>
                                </span>
                                <span class="breadcrumb-separator">/</span>
                                <span property="itemListElement" typeof="ListItem">Product Details</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area-end -->

        

        <!-- shop-details-area -->
        <section class="shop__details-area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-lg-6">
                        <div class="shop__details-img">
                            <?php
                                // Fetch images from the upload table based on the image IDs in the images column
                                $imageIds = explode(',', $product['images']);
                                $images = [];

                                if (!empty($imageIds)) {
                                $placeholders = implode(',', array_fill(0, count($imageIds), '?'));
                                $imageQuery = "SELECT file_original_name FROM upload WHERE id IN ($placeholders)";
                                $stmt = $conn->prepare($imageQuery);
                                $stmt->bind_param(str_repeat('i', count($imageIds)), ...array_map('intval', $imageIds));
                                $stmt->execute();
                                $imageResult = $stmt->get_result();

                                while ($image = $imageResult->fetch_assoc()) {
                                    $images[] = "uploads/assets/" . $image['file_original_name'];
                                }
                                $stmt->close();
                                }
                            ?>
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $index => $imageLink): ?>
                                    <?php if($imageLink){?>
                                        <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($imageLink); ?>">
                                    <?php }else{ ?>
                                        <img src="images/default.png" alt="default">
                                    <?php } ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <?php endif; ?>
                            <span class="sticker">SALE</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shop__details-content">
                            <!-- <h4 class="price">$150.00 <del>$260.00</del></h4> -->
                            <h2 class="title"><?php echo htmlspecialchars($product['name']); ?></h2>
                            <div class="review-wrap">
                                <div class="rating">
                                <?php
                                    $sel = "SELECT name,logo,extension FROM brand WHERE id = " . intval($product['brand_id']);
                                    $brandresult = $conn->query($sel);
                                        if ($brandresult && $brandresult->num_rows > 0) {
                                        $brand = $brandresult->fetch_assoc();             
                                        }
                                ?>
                                <?php
                                    if (!empty($brand['logo']) && !empty($brand['extension'])) {
                                        $brandLogo = "uploads/assets/logos/" . $brand['logo'] . "." . $brand['extension'];
                                ?>
                                <a href="brands.php?id=<?php echo intval($product['brand_id']); ?>">
                                    <img src="<?php echo $brandLogo; ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image" style="width:15rem;">
                                </a>
                                <?php
                                } else {
                                ?>
                                <h4 class="price">Brand : 
                                    <del>
                                        <a href="brands.php?id=<?php echo intval($product['brand_id']); ?>">
                                            <span class="title"><?php echo htmlspecialchars($brand['name']); ?></span>
                                        </a>
                                    </del>
                                </h4>
                                <?php } ?>
                                    <!-- <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i> -->
                                </div>
                                <!-- <span>(2 customer reviews)</span> -->
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($product['short_description'])); ?></p>
                            <?php if(!empty($product['features']) && is_array($product['features'])) { ?>
                            <div class="shop__list-wrap">Features:
                                <ul class="list-wrap">
                                <?php
                                    $featuresJson=$product['features'];
                                    // Decode the JSON into an array
                                    $features = json_decode($featuresJson, true);

                                    // Iterate through each feature and remove <li> tags
                                    foreach ($features as $feature) {
                                        if (is_string($feature)) {
                                            // Strip <li> and </li> tags and output the feature
                                            $cleanFeature = strip_tags($feature);
                                    ?>
                                    <li><i class="far fa-check-circle"></i><?php echo $cleanFeature; ?></li>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <?php } ?>
                            <?php if(!empty($product['shop_lines']) && is_array($product['shop_lines'])) { ?>
                            <div class="shop__list-wrap">Shop Lines:
                                <ul class="list-wrap">
                                <?php
                                    $shopJson=$product['shop_lines'];
                                    // Decode the JSON into an array
                                    $shop_lines = json_decode($shopJson, true);

                                    // Iterate through each feature and remove <li> tags
                                    foreach ($shop_lines as $shop) {
                                        if (is_string($shop)) {
                                            // Strip <li> and </li> tags and output the feature
                                            $cleanFeature = strip_tags($shop);
                                    ?>
                                    <li><i class="far fa-check-circle"></i><?php echo $cleanFeature; ?></li>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <?php } ?>
                            <div class="shop__details-qty">
                                <!-- <div class="cart-plus-minus">
                                    <form action="#" class="num-block">
                                        <input type="text" class="in-num" value="1" readonly="">
                                        <div class="qtybutton-box">
                                            <span class="plus"><i class="renova-down-arrow"></i></span>
                                            <span class="minus dis"><i class="renova-down-arrow"></i></span>
                                        </div>
                                    </form>
                                </div> -->

                                <a href="shop-details.html" class="btn btn-two">Add To Cart</a>
                            </div>
                            <style>
              .gmail-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background-color: #DB4437;
                color: #fff;
                font-size: 18px;
                font-weight: 600;
                text-decoration: none;
                padding: 12px 25px;
                border-radius: 50px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
              }

              .gmail-button img {
                margin-right: 10px;
                width: 24px;
                height: 24px;
              }

              .gmail-button:hover {
                background-color: #C03527;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
              }
            </style>
            <div class="cc" style="display:flex; flex-direction:row; justify-content: start; gap: 3vw; align-items: center;">
              <a href="images/pdf.png" download="">
                <img class="brochure-pdf" src="images/pdf.png" alt="pdf" style="max-width:160px">
              </a>
              <a href="mailto:your-email@gmail.com" style="background: #262424; padding: 5px 10px; border-radius: 8px; margin: 5px;">
                <img src="images/gmail.png" alt="mail" style="width: 30px;">
                <span style="color:white; font-weight:bold;">Send Email</span>
              </a>
            </div>
                            <div class="shop__details-bottom">
                                <ul class="list-wrap">
                                    <li class="sd-sku">
                                        <span class="title">SKU:</span>
                                        <span class="code"><?php echo htmlspecialchars($product['sku']); ?></span>
                                    </li>
                                    <li class="sd-category">
                                        <span class="title">Category:</span>
                                        <a href="shop-details.html"><?php echo htmlspecialchars($product['category']); ?></a>
                                    </li>
                                    <!-- <li class="sd-tag">
                                        <span class="title">Tags:</span>
                                        <a href="shop-details.html">automotive parts,</a>
                                        <a href="shop-details.html">wheels</a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-desc-wrap">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                                    <p><?php echo nl2br(htmlspecialchars($product['descriptions'])); ?></p>
                                </div>
                                <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                                    <div class="product-desc-review">
                                        <div class="product-desc-review-title mb-15">
                                            <h5 class="title">Customer Reviews (0)</h5>
                                        </div>
                                        <div class="left-rc">
                                            <p>No reviews yet</p>
                                        </div>
                                        <div class="right-rc">
                                            <a href="#">Write a review</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-details-area-end -->

        <!-- related-shop-area -->
        <section class="related__shop-area section-pb-95">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section__title section__title-three text-center mb-60">
                            <span class="sub-title">Product Line</span>
                            <h2 class="title">Our Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper related__shop-active fix">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="shop__item">
                                        <div class="shop__thumb">
                                            <img src="assets/img/product/shop_img01.png" alt="img">
                                            <a href="shop-details.html" class="btn">Add To Cart</a>
                                            <span class="sticker">NEW</span>
                                        </div>
                                        <div class="shop__content">
                                            <h6 class="price">$250.00 <del>$550.00</del></h6>
                                            <h4 class="title"><a href="shop-details.html">Concrete Admixtures</a></h4>
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
                                <div class="swiper-slide">
                                    <div class="shop__item">
                                        <div class="shop__thumb">
                                            <img src="assets/img/product/shop_img02.png" alt="img">
                                            <a href="shop-details.html" class="btn">Add To Cart</a>
                                        </div>
                                        <div class="shop__content">
                                            <h6 class="price">$170.00</h6>
                                            <h4 class="title"><a href="shop-details.html">Rebar Reinforcement Bars</a></h4>
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
                                <div class="swiper-slide">
                                    <div class="shop__item">
                                        <div class="shop__thumb">
                                            <img src="assets/img/product/shop_img03.png" alt="img">
                                            <a href="shop-details.html" class="btn">Add To Cart</a>
                                            <span class="sticker">SALE</span>
                                        </div>
                                        <div class="shop__content">
                                            <h6 class="price">$270.00 <del>$460.00</del></h6>
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
                                <div class="swiper-slide">
                                    <div class="shop__item">
                                        <div class="shop__thumb">
                                            <img src="assets/img/product/shop_img04.png" alt="img">
                                            <a href="shop-details.html" class="btn">Add To Cart</a>
                                        </div>
                                        <div class="shop__content">
                                            <h6 class="price">$300.00</h6>
                                            <h4 class="title"><a href="shop-details.html">Plywood Trolly</a></h4>
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
                                <div class="swiper-slide">
                                    <div class="shop__item">
                                        <div class="shop__thumb">
                                            <img src="assets/img/product/shop_img05.png" alt="img">
                                            <a href="shop-details.html" class="btn">Add To Cart</a>
                                            <span class="sticker">SALE</span>
                                        </div>
                                        <div class="shop__content">
                                            <h6 class="price">$320.00 <del>$680.00</del></h6>
                                            <h4 class="title"><a href="shop-details.html">Roofing Shingles</a></h4>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- related-shop-area-end -->

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