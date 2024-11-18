<?php include("api/db_connection.php"); ?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $productQuery = "SELECT *, TIMESTAMPDIFF(HOUR, created_at, NOW()) AS hours_since_creation FROM products";
// $result = $conn->query($productQuery);

// if ($result->num_rows === 0) {
//     echo "No products found.";
//     $conn->close();
//     exit;
// }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Brands - Walvoil</title>
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
    <?php include("inc_files/loader.php"); ?>
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
        .image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .text3 {
            flex: 2;
        }
    </style>

<div class="container1">
        <div class="image2">
            <img src="https://via.placeholder.com/300" alt="Demo Image">
        </div>
        <div class="text3">
            <h2>Lorem Ipsum</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet accumsan tortor. Curabitur laoreet, lacus sit amet sodales vestibulum, lectus risus aliquam elit, at bibendum elit odio eu mi. Integer eu sapien quis felis consequat scelerisque. Nulla facilisi. Sed fringilla ipsum nec velit hendrerit, ut dictum lorem consequat.</p>
        </div>
    </div>

    <section id="feature_product" class="bottom_half">
    <div class="container">
        <div class="row">
            <?php
            // Define an array with the two brands you want to display
            $allowedBrands = ['Brand1', 'Brand2'];

            while ($product = $result->fetch_assoc()):
                // Check if the product's brand is in the allowed brands array
                if (in_array($product['brand'], $allowedBrands)):
            ?>
                <div class="col-md-3 col-sm-6">
                    <div class="product_wrap bottom_half" style="padding-bottom: 0px; padding: 5px; border-radius: 20px; margin-bottom: 5px; box-shadow:-1px 4px 19px -9px rgba(0, 0, 0, 0.5); background-color: white;">
                        <?php if ($product['hours_since_creation'] <= 24): ?>
                            <div style="width: 0; height: 0; border-bottom: 10px solid transparent; border-top: 50px solid #79b6c8; border-left: 15px solid #79b6c8; border-right: 15px solid #79b6c8; display: inline-block;" class="tag-btn">
                                <span class="uppercase text-center">New</span>
                            </div>
                        <?php endif; ?>
                        <div class="image" style="width:100%;">
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
                                <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="display: block; width: 14vw; padding: 1vw; margin: 1vw;" class="img-responsive">
                            </a>
                        </div>
                        <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="fancybox">
                            <div class="product_desc" style="padding: 1vw; margin: 1vw; height: 15vh; display: flex; flex-direction: column; justify-content: space-evenly; text-align: center;">
                                <p><span style="text-align: center;" class="title"><?php echo htmlspecialchars($product['name']); ?></span></p>
                                <p style="color: #049ddf; font-weight: bold; text-align: center">Brand: <span class="title"><?php echo htmlspecialchars($product['brand']); ?></span></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php
                endif; // End brand check
            endwhile;
            ?>
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