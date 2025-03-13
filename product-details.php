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
                                </ul>
                            <p><?php echo nl2br(htmlspecialchars($product['short_description'])); ?></p>

                        <style>
                            .feature_lists{
                                /* margin-left: 35px; */
                            }
                        </style>
                        <!-- Features datas -->
                        <?php if (!empty($product['features']) && is_string($product['features'])) { ?>
                            <div class="shop__list-wrap feature_lists">
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
                        <?php } ?>

                            <div class="shop__details-qty" style="">
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
                                <?php
                                    $pdfUrl = ""; // Default empty PDF URL

                                    if (!empty($product['pdf_id'])) {
                                        $pdfId = $product['pdf_id'];
                                        
                                        // Fetch file_original_name from the upload table using pdf_id
                                        $stmt = $conn->prepare("SELECT file_original_name FROM upload WHERE id = ?");
                                        $stmt->bind_param("i", $pdfId);
                                        $stmt->execute();
                                        $stmt->bind_result($fileOriginalName);
                                        $stmt->fetch();
                                        $stmt->close();

                                        if (!empty($fileOriginalName)) {
                                            // First, check if the file exists in "uploads/bro/"
                                            if (file_exists("uploads/bro/" . $fileOriginalName)) {
                                                $pdfUrl = "uploads/bro/" . htmlspecialchars($fileOriginalName, ENT_QUOTES, 'UTF-8');
                                            }
                                            // If not found, check "uploads/brochure/"
                                            elseif (file_exists("uploads/brochure/" . $fileOriginalName)) {
                                                $pdfUrl = "uploads/brochure/" . htmlspecialchars($fileOriginalName, ENT_QUOTES, 'UTF-8');
                                            }
                                        }
                                    }

                                    // Case: pdf_id does not exist
                                    elseif (empty($product['pdf_id'])) {
                                        if (!empty($product['pdf']) && $product['pdf'] != 'NA') {
                                            $pdfValue = trim($product['pdf']);

                                            // If the PDF value is a full URL (starts with "https://"), use it directly
                                            if (strpos($pdfValue, "https://") === 0) {
                                                $pdfUrl = $pdfValue;
                                            }
                                            // Otherwise, check if the file exists in "uploads/brochure/"
                                            elseif (file_exists("uploads/brochure/" . $pdfValue)) {
                                                $pdfUrl = "uploads/brochure/" . htmlspecialchars($pdfValue, ENT_QUOTES, 'UTF-8');
                                            }
                                        }
                                    }

                                    // Display the PDF link if a valid URL exists
                                    if (!empty($pdfUrl)): ?>
                                        <div class="pdfbtn">
                                            <a href="<?php echo $pdfUrl; ?>" target="_blank">
                                                <div class="pdfimg">
                                                    <img class="brochure-pdf" src="images/pdf.png" alt="pdf" style="">
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                <br/>
                                <style>
                                    /* pdf button */
                                    .pdfimg img{
                                        width: 100%;
                                        height: 4rem;
                                    }
                                    .pdfimg{
                                        width: 13rem;
                                        height: 4rem;
                                        background: #262424;
                                        border-radius: 15px;
                                        margin: 5px;
                                        display: flex;
                                        align-items: center;
                                    }
                                    /* Main button box */
                                    .shop__details-qty {
                                        display:flex;
                                        flex-wrap: wrap;
                                        margin-bottom: 0px;
                                        gap:10px;
                                    }

                                    /* email button */
                                    .emailbtn{
                                        width: 13rem;
                                        height: 4rem;
                                        background: #262424; 
                                        padding: 5px 10px; 
                                        border-radius: 8px; 
                                        margin: 5px; 
                                        justify-content: space-evenly;  
                                        display: flex; 
                                        align-items: center;
                                    }
                                    .emailbtn a{
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    }

                                    /* Whatsapp btn */
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
                                
                                <div class="emailbtn">
                                    <a href="mailto:hussunally@gmail.com" style="">
                                        <img src="images/gmail.png" alt="mail" style="width: 60px;">
                                        <span style="color:white; font-weight:bold; font-size:25px">Send Email</span>
                                    </a>
                                </div>
                                <br/>
                                <div class="whatsapp-button">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
                                    <a href="https://wa.me/+919831420324?text=I'm%20interested%20in%20your%20product">
                                        Mr. Huzefa / An Hussuanally & Co.<br>Need help? Chat via WhatsApp
                                    </a>
                                </div>
                            </div>
                            <div class="shop__details-bottom">
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