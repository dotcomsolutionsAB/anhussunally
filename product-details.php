<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("connection/db_connect.php");
    // Establish database connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
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
        <?php include("inc_files/breadcrumb.php"); ?>
        <!-- breadcrumb-area-end -->

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
        
?>

    
    <title>
        <?php echo htmlspecialchars($product['name']); ?>
    </title>
    
        <!-- shop-details-area -->
        <section class="shop__details-area section-py-120">
            <div class="container">
                <div class="row gutter-24">
                    <div class="col-lg-6">
                        <div class="shop__details-img" style="display: flex; justify-content: center; align-items: center;">
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
                                // $stmt->close();
                                }
                            ?>
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $index => $imageLink): ?>
                                    <?php if($imageLink){?>
                                        <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($imageLink); ?>" style="display: flex;  justify-content: center;
                                            align-items: center;">
                                    <?php }else{ ?>
                                        <img src="images/default.png" alt="default" style="display: flex;  justify-content: center;
                                            align-items: center;">
                                    <?php } ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <?php endif; ?>
                            <!-- <span class="sticker">SALE</span> -->
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="shop__details-content">
                            <!-- <h4 class="price">$150.00 <del>$260.00</del></h4> -->
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
                                    <a href="#">
                                        <img src="<?php echo $brandLogo; ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image" style="width:8rem;">
                                    </a>
                                <?php
                                } else {
                                ?>
                                    <h4 class="price">Brand : 
                                        <a href="brands.php?id=<?php echo intval($product['brand_id']); ?>">
                                            <span class="title"><?php echo htmlspecialchars($brand['name']); ?></span>
                                        </a>
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
                                <h2 class="title"><?php echo htmlspecialchars($product['name']); ?></h2>
                                <ul class="list-wrap">
                                    <li class="sd-sku">
                                        <span class="title" style="min-width: 35px;">SKU:</span>
                                        <span class="code"><?php echo htmlspecialchars($product['sku']); ?></span>
                                    </li>
                                    <?php
                                        $selt = "SELECT name FROM categories WHERE id = " . intval($product['category_id']);
                                        $catresult = $conn->query($selt);
                                            if ($catresult && $catresult->num_rows > 0) {
                                            $category = $catresult->fetch_assoc();             
                                            }
                                    ?>
                                    <li class="sd-category">
                                        <span class="title" style="min-width: 35px;">Category:</span>
                                        <a href="#"><?php echo htmlspecialchars($category['name']); ?></a>
                                    </li>
                                    <!-- <li class="sd-tag">
                                        <span class="title">Tags:</span>
                                        <a href="shop-details.html">automotive parts,</a>
                                        <a href="shop-details.html">wheels</a>
                                    </li> -->
                                </ul>
                            <p><?php echo nl2br(htmlspecialchars($product['short_description'])); ?></p>
                            
                            <div class="shop__details-qty" style="display: block!important;">
                                
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
                                <?php if (!empty($product['pdf'])): ?>
                                    <a href="<?php echo htmlspecialchars($product['pdf'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
                                        <img class="brochure-pdf" src="images/pdf.png" alt="pdf" style="width: 20rem; height: 6rem;">
                                    </a>
                                <?php endif; ?>
                                <br/>
                                <style>
                                    .whatsapp-button {
                                        margin-top: 20px;
                                        padding: 10px;
                                        background-color: #25D366;
                                        color: white;
                                        border-radius: 5px;
                                        display: flex;
                                        align-items: center;
                                        max-width: 20rem;
                                        cursor: pointer;
                                        flex-wrap: wrap;
                                    }

                                    .whatsapp-button img {
                                        width: 42px;
                                        height: 50px;
                                        margin-right: 10px;
                                        flex-shrink: 0;
                                    }

                                    .whatsapp-button a {
                                        text-decoration: none;
                                        color: white;
                                        font-size: 16px;
                                        text-align: left;
                                        line-height: 1.2;
                                    }

                                    @media (max-width: 520px) {
                                        .whatsapp-button {
                                        flex-direction: row;
                                        padding: 5px 5px;
                                        margin-top: 5px;
                                        max-width: 18rem;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                        }
                                        .whatsapp-button img {
                                        margin-bottom: 0px;
                                        margin-right: 0;
                                        }
                                        .whatsapp-button a {
                                            margin-left: 5px;
                                        }
                                    }
                                </style>
                                <div class="whatsapp-button">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
                                    <a href="https://wa.me/+919831420324?text=I'm%20interested%20in%20your%20product">
                                        Mr. Huzefa / An Hussuanally & Co.<br>Need help? Chat via WhatsApp
                                    </a>
                                </div>
                                <br/>
                                <a href="mailto:hussunally@gmail.com" style="background: #262424; padding: 5px 10px; border-radius: 8px; margin: 5px; width:20rem;
                                        height: 6rem; justify-content: space-evenly;  display: flex; align-items: center;">
                                    <img src="images/gmail.png" alt="mail" style="width: 60px;">
                                    <span style="color:white; font-weight:bold; font-size:25px">Send Email</span>
                                </a>
                            </div>
                            <div class="shop__details-bottom">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="product-desc-wrap">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <?php if (!empty($product['descriptions']) && trim($product['descriptions']) !== '') { ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
                                    </li>
                                <?php } ?>

                                <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Reviews</button>
                                </li> -->
                                <?php if (!empty($product['features']) && is_string($product['features'])) { ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features-tab-pane" type="button" role="tab" aria-controls="features-tab-pane" aria-selected="false">Features</button>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($product['shop_lines']) && is_string($product['shop_lines'])) { ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="shoplines-tab" data-bs-toggle="tab" data-bs-target="#shoplines-tab-pane" type="button" role="tab" aria-controls="shoplines-tab-pane" aria-selected="false">Shop Lines</button>
                                    </li>
                                <?php } ?>
                            </ul>

                            <div class="tab-content" id="myTabContent2">

                                <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                                    <?php if (!empty($product['descriptions'])) { ?>
                                        <?php echo $product['descriptions']; ?>
                                    <?php } ?>
                                </div>
                                
                                <!-- Features datas -->
                                <?php if (!empty($product['features']) && is_string($product['features'])) { ?>
                                    <div class="tab-pane fade" id="features-tab-pane" role="tabpanel" aria-labelledby="features-tab" tabindex="0">
                                        <div class="shop__list-wrap">
                                            <?php
                                            // Decode the JSON into an associative array
                                            $featuresJson = $product['features'];
                                            $featuresArray = json_decode($featuresJson, true);

                                            // Check if the decoded result is an array
                                            if (is_array($featuresArray)) {
                                                ?>
                                                <h3>Features:</h3>
                                                <ul class="list-wrap">
                                                <?php
                                                // Iterate through the features and render them
                                                foreach ($featuresArray as $feature) {
                                                    // Ensure the feature is a valid string
                                                    if (is_string($feature)) {
                                                        // Decode HTML entities to render them properly
                                                        $renderedFeature = htmlspecialchars_decode($feature);
                                                        ?>
                                                        <li><i class="far fa-check-circle"></i><?php echo $renderedFeature; ?></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>


                                <!-- Shoplines data -->
                                <?php if (!empty($product['shop_lines']) && is_string($product['shop_lines'])) { ?>
                                    <div class="tab-pane fade" id="shoplines-tab-pane" role="tabpanel" aria-labelledby="shoplines-tab" tabindex="0">
                                        <div class="shop__list-wrap">
                                            <h3>Shop Lines:</h3>
                                            <ul class="list-wrap">
                                            <?php
                                                // Decode the JSON into an array
                                                $shopJson = $product['shop_lines'];
                                                $shop_lines = json_decode($shopJson, true);

                                                // Check if the decoded result is an array
                                                if (is_array($shop_lines)) {
                                                    // Iterate through each shop line
                                                    foreach ($shop_lines as $shop) {
                                                        if (is_string($shop)) {
                                                            // Output the shop line with HTML rendered correctly
                                                            $renderedShopLine = htmlspecialchars_decode($shop);
                                                            ?>
                                                            <li><i class="far fa-check-circle"></i><?php echo $renderedShopLine; ?></li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>

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
                            <h2 class="title">Our Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper related__shop-active fix">
                            <div class="swiper-wrapper">
                                <?php
                                    // Fetch related products from the same brand with image details
                                    $brand = $product['brand_id'];
                                    $sku = $product['sku'];
                                    
                                    $relatedProductsQuery = "
                                        SELECT 
                                            p.sku, 
                                            p.name AS product_name, 
                                            p.brand_id, 
                                            b.name AS brand_name,
                                            p.images,
                                            TIMESTAMPDIFF(HOUR, p.created_at, NOW()) AS hours_since_creation,
                                            u.file_original_name AS image_path
                                        FROM 
                                            products p
                                        LEFT JOIN 
                                            upload u ON u.id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM p.images), ',', 1) AS UNSIGNED)
                                        LEFT JOIN 
                                            brand b ON p.brand_id = b.id
                                        WHERE 
                                            p.brand_id = ? AND p.sku != ? 
                                        LIMIT 6";
                                    
                                    $stmt = $conn->prepare($relatedProductsQuery);
                                    $stmt->bind_param("ss", $brand, $sku);
                                    $stmt->execute();
                                    $relatedProductsResult = $stmt->get_result();
                                ?>
                                <?php while ($relatedProduct = $relatedProductsResult->fetch_assoc()) { ?>
                                    <div class="swiper-slide">
                                        <div class="shop__item">
                                            <div class="shop__thumb" style="padding:10px;">
                                            <img 
                                                src="uploads/assets/<?php echo htmlspecialchars($relatedProduct['image_path'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                alt="<?php echo htmlspecialchars($relatedProduct['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                                            >

                                                <a href="product-details.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>" class="btn">View Details</a>
                                                <!-- <?php if ($relatedProduct['hours_since_creation'] < 72) { // Mark as NEW if created within the last 72 hours ?>
                                                    <span class="sticker">NEW</span>
                                                <?php } ?> -->
                                            </div>
                                            <div class="shop__content">
                                                <h6 class="price">SKU : <span><?php echo htmlspecialchars($relatedProduct['sku']); ?></span></h6>
                                                <h4 class="title"><a href="product-details.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                                                    <?php echo strlen($relatedProduct['product_name']) > 36 ? htmlspecialchars(substr($relatedProduct['product_name'], 0, 24)) . '...' : htmlspecialchars($relatedProduct['product_name']); ?>
                                                </a></h4>
                                                <!-- <p class="">Brand :<span><?php echo htmlspecialchars($relatedProduct['brand_name']); ?></span></p> -->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- related-shop-area-end -->

        <!-- cta-area -->
        <?php include("inc_files/cta_area.php"); ?>
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

<?php $stmt->close(); ?>