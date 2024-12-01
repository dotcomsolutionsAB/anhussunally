<?php include("api/db_connection.php"); ?>
<?php 
  // Include the configuration file
  include(__DIR__ . '/inc_files/config.php');
?>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products with their brand names
$productQuery = "SELECT products.*, brand.name AS brand_name, TIMESTAMPDIFF(HOUR, products.created_at, NOW()) AS hours_since_creation
                 FROM products
                 LEFT JOIN brand ON products.brand_id = brand.id";
$result = $conn->query($productQuery);

if ($result->num_rows === 0) {
    echo "No products found.";
    $conn->close();
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>AN Hussunally & Co</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.transitions.css">
    <link rel="stylesheet" type="text/css" href="css/cubeportfolio.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="css/bootsnav.css">
    <link rel="stylesheet" type="text/css" href="css/settings.css">
    <link rel="stylesheet" type="text/css" href="css/loader.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png">
</head>

<body>

    <!-- Loader -->
    <!-- <?php include("inc_files/loader.php"); ?> -->
    <!-- HEADER -->
    <?php include("inc_files/header.php"); ?>
    <!-- Breadcumb -->
    <?php include("inc_files/breadcumb.php"); ?>

<style>
        /* General Styling for Related Products */
        #feature_product {
            padding: 30px 0;
        }

        #feature_product .heading {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .product_wrap {
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
            box-shadow: -1px 4px 19px -9px rgba(0, 0, 0, 0.5);
            background-color: white;
            transition: box-shadow 0.3s ease;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .product_wrap:hover {
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product_desc {
            padding: 10px;
            margin-top: 10px;
        }

        .product_desc .title {
            font-size: 16px;
            line-height: 1.5;
        }

        /* CSS Grid for the product container */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Default 4 columns for desktop */
            gap: 15px;
            padding: 15px 0;
        }
        
        /* Mobile and Tablet Responsiveness */

        /* For small screens (mobile, tablets) */
        @media (max-width: 767px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr); /* 2 products per row */
            }
            
            .product_desc .title {
                font-size: 14px;
            }
            .stylish-linkab {
                font-size: 12px;
                padding: 8px 12px;
            }
        }

        /* For large screens (desktops) */
        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr); /* 4 products per row on larger screens */
            }
        }
        @media (max-width: 480px) {
            .product_wrap {
                width: 45vw;
            }
			.product-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 products per row */
            }
        }
       
        .stylish-linkab {
            display: flex;
            width: 120px;
            border-radius: 15px;
            text-align: center;
            background-color: #3ab6e9;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stylish-linkab:hover {
            color: #f0f0f0;
            text-decoration: none;
        }
</style>

<section id="feature_product" >
    <div class="container">
        <div class="product-grid">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product_wrap">                        
                        <!-- New Product Tag -->
                        <?php if ($product['hours_since_creation'] <= 24): ?>
                            <div style="width: 0; height: 0; border-bottom: 10px solid transparent; border-top: 50px solid #79b6c8; border-left: 15px solid #79b6c8; border-right: 15px solid #79b6c8; display: inline-block;" class="tag-btn">
                                <span class="uppercase text-center">New</span>
                            </div>
                        <?php endif; ?>

                        <!-- Product Image -->
                        <div class="image" style="">
                            <?php
                            if (!empty($product['images']) && $product['images'] != '') {
                                $imageIds = explode(',', $product['images']);
                                $firstImageId = $imageIds[0] ?? null;

                                if ($firstImageId) {
                                    $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                                    $imageResult = $conn->query($imageQuery);
                                    if ($imageResult && $imageResult->num_rows > 0) {
                                        $image = $imageResult->fetch_assoc();
                                        $imageLink = "api/uploads/assets/" . $image['file_original_name'];
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
                            <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>">
                                <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-responsive" style="max-width: 100%; height: auto;">
                            </a>
                        </div>

                        <!-- Product Description -->
                        <div class="product_desc" style="">
                            <p class="title"><?php echo htmlspecialchars($product['name']); ?></p>
                            <!-- <p style="color: #049ddf; font-weight: bold; text-align: center">Brand: <span class="title"><?php echo htmlspecialchars($product['brand_name']); ?></span></p> -->
                        </div>

                        <!-- Button -->
                        <div class="btn">
                            <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="stylish-linkaa" style="padding: 8px 15px;">Read More</a>
                        </div>
                    
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>



    <!-- Footer -->
    <?php include("inc_files/footer.php"); ?>

    <script src="js/jquery-2.2.3.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOBKD6V47-g_3opmidcmFapb3kSNAR70U"></script>
    <script src="js/gmap3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootsnav.js"></script>
    <script src="js/jquery.parallax-1.1.3.js"></script>
    <script src="js/jquery.appear.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.cubeportfolio.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/jquery.themepunch.tools.min.js"></script>
    <script src="js/jquery.themepunch.revolution.min.js"></script>
    <script src="js/revolution.extension.layeranimation.min.js"></script>
    <script src="js/revolution.extension.navigation.min.js"></script>
    <script src="js/revolution.extension.parallax.min.js"></script>
    <script src="js/revolution.extension.slideanims.min.js"></script>
    <script src="js/revolution.extension.video.min.js"></script>
    <script src="js/kinetic.js"></script>
    <script src="js/jquery.final-countdown.js"></script>
    <script src="js/functions.js"></script>

</body>
</html>

<?php $conn->close(); ?>
