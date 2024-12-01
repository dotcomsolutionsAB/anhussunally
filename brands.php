<?php 
  // Include the configuration file
  // include(__DIR__ . '/inc_files/config.php');
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ini_set('display_errors', 0);

include("api/db_connection.php");

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the brand ID from the URL
$brandId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch brand details
$brandQuery = "SELECT name, specifications, logo, extension FROM brand WHERE id = $brandId";
$brandResult = $conn->query($brandQuery);

if ($brandResult && $brandResult->num_rows > 0) {
    $brand = $brandResult->fetch_assoc();
    $brandName = $brand['name'];
    $brandDescription = $brand['specifications'];
    $brandLogo = $brand['logo'] . "." . $brand['extension'];
} else {
    echo "Brand not found.";
    $conn->close();
    exit;
}

if (empty($brandDescription)) {
    $brandDescription = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum voluptatem quo facilis sapiente molestiae delectus labore excepturi eveniet temporibus repellendus! Odio laborum autem vitae sint!";
}

if (!empty($brandLogo)) {
    $brandLogo = "uploads/assets/logos/" . $brandLogo;
} else {
    $brandLogo = "images/default.png";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Brand - <?php echo htmlspecialchars($brandName); ?></title>
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

    <!-- HEADER -->
    <?php include("inc_files/header.php"); ?>

    <!-- Breadcumb -->
    <?php include("inc_files/breadcumb.php"); ?>

    <style>
        .container1 {
            display: flex;
            align-items: center;
            padding: 20px;
        }
        .image2 {
            flex: 1;
            padding-right: 20px;
        }
        .image2 img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .text3 {
            flex: 2;
        }
        @media (max-width: 767px) {
            .container1 {
                flex-direction: column;
            }
        }
    </style>

    <div class="container">
        <div class="container1">
            <div class="image2">
                <img src="<?php echo $brandLogo; ?>" alt="<?php echo htmlspecialchars($brandName); ?> Image">
            </div>
            <div class="text3">
                <!-- <h2><?php echo htmlspecialchars($brandName); ?></h2> -->
                <br>
                <p><?php echo htmlspecialchars($brandDescription); ?></p>
            </div>
        </div>
    </div>
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
                grid-template-columns: repeat(2, 1fr); /* 2 products per row */
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

<?php
    // Fetch related products from the same brand
    $relatedProductsQuery = "SELECT * FROM products WHERE brand_id = ?";
    $stmt = $conn->prepare($relatedProductsQuery);
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $relatedProductsResult = $stmt->get_result();
?>

<section id="feature_product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="heading uppercase bottom30">Related Products</h4>
            </div>
        </div>
        <div class="product-grid">
            <?php while ($relatedProduct = $relatedProductsResult->fetch_assoc()): ?>
                <div class="product_wrap">
                    <div class="image">
                        <?php
                        // Get the first image from the product's images column
                        $imageIds = explode(',', $relatedProduct['images']);
                        $firstImageId = $imageIds[0] ?? null;

                        // If there's an image, get its filename from the database, otherwise use the default
                        if ($firstImageId) {
                            $imageQuery = "SELECT file_original_name FROM upload WHERE id = ?";
                            $imageStmt = $conn->prepare($imageQuery);
                            $imageStmt->bind_param("i", $firstImageId);
                            $imageStmt->execute();
                            $imageResult = $imageStmt->get_result();
                            
                            if ($imageResult && $imageResult->num_rows > 0) {
                                $image = $imageResult->fetch_assoc();
                                $imageLink = "api/uploads/assets/" . $image['file_original_name'];
                            } else {
                                $imageLink = "images/default.png"; // Fallback if no image found
                            }
                        } else {
                            $imageLink = "images/default.png"; // Fallback if no image IDs
                        }

                        $productNames = htmlspecialchars($relatedProduct['name']);
                        $words = explode(' ', $productNames);
                        if (count($words) > 2) {
                            echo htmlspecialchars(implode(' ', array_slice($words, 0, 3))) . '...';
                        } else {
                            echo $productNames;
                        }
                        ?>
                        <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>">
                            <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="image" class="img-responsive">
                        </a>
                    </div>
                    <div class="product_desc">
                        <p class="title"><?php echo htmlspecialchars($productNames); ?></p>
                    </div>
                    <div class="btn">
                        <a href="product_detail.php?sku=<?php echo htmlspecialchars($relatedProduct['sku']); ?>" class="stylish-linkab">Read More</a>
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

<?php
$conn->close();
?>
