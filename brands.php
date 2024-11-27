<?php include("api/db_connection.php"); ?>
<?php 
  // Include the configuration file
  include(__DIR__ . '/inc_files/config.php');
?>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// ini_set('display_errors', 0);

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the brand ID from the URL
$brandId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch brand details
$brandQuery = "SELECT name, description,logo,extension FROM brand WHERE id = $brandId";
$brandResult = $conn->query($brandQuery);

if ($brandResult && $brandResult->num_rows > 0) {
    $brand = $brandResult->fetch_assoc();
    $brandName = $brand['name'];
    $brandDescription = $brand['description'];
    $brandLogo = $brand['logo'].".".$brand['extension'];

    // if ($brand['logo'] !='' && $brand['extension'] != '') {
    //     $brandLogo = "uploads/assets/logos/" . $brandLogo;
    // } else {
    //     $brandLogo = "images/default.png";
    // }
} else {
    echo "Brand not found.";
    $conn->close();
    exit;
}
if (empty($brandDescription)) {
    $brandDescription = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum voluptatem quo facilis sapiente molestiae delectus labore excepturi eveniet temporibus repellendus! Odio laborum autem vitae sint! NULL DATA IN DATABASE ";
}

if (!empty($brandLogo) || $brandLogo != '') {
    $brandLogo = "uploads/assets/logos/" . $brandLogo;
} else {
    $brandLogo = "images/default.png";
}

// Fetch products for the given brand
$productQuery = "SELECT *, TIMESTAMPDIFF(HOUR, created_at, NOW()) AS hours_since_creation FROM products WHERE brand_id = $brandId";
$result = $conn->query($productQuery);

if ($result->num_rows === 0) {
    echo "No products found for this brand.";
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

    <!-- Loader -->

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
    </style>

    <div class="container">
        <div class="container1">
            <div class="image2">
                <img src="<?php echo $brandLogo; ?>" alt="<?php echo htmlspecialchars($brandName); ?> Image">
            </div>
            <div class="text3">
                <h2><?php echo htmlspecialchars($brandName); ?></h2>
                <br>
                <p><?php echo htmlspecialchars($brandDescription); ?></p>
            </div>
        </div>
    </div>

    <section id="feature_product" class="bottom_half">
        <div class="container">
            <div class="row">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product_wrap bottom_half" style="padding-bottom: 0px; padding: 5px; border-radius: 20px; margin-bottom: 5px; box-shadow: -1px 4px 19px -9px rgba(0, 0, 0, 0.5); background-color: white;">
                            <?php if ($product['hours_since_creation'] <= 24): ?>
                                <div style="width: 0; height: 0; border-bottom: 10px solid transparent; border-top: 50px solid #79b6c8; border-left: 15px solid #79b6c8; border-right: 15px solid #79b6c8; display: inline-block;" class="tag-btn">
                                    <span class="uppercase text-center">New</span>
                                </div>
                            <?php endif; ?>
                            <div class="image" style="width:100%;">
                                <?php
                                if (!empty($product['images'])) {
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
                                    <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="display: block; width: 14vw;" class="img-responsive">
                                </a>
                            </div>
                            
                                <div class="product_desc" style="height: 10vh; display: flex; flex-direction: column; justify-content: flex-start; text-align: center;">
                                    <!-- <p><?php echo htmlspecialchars($product['name']); ?></span></p> -->
                                    <p>
                                        <span class="title">
                                            <?php 
                                                $productName = htmlspecialchars($product['name']);
                                                $words = explode(' ', $productName);
                                                if (count($words) > 3) {
                                                    echo htmlspecialchars(implode(' ', array_slice($words, 0, 5))) . '...';
                                                } else {
                                                    echo $productName;
                                                } 
                                            ?> 
                                        </span>
                                    </p>
                                    <!-- <p style="color: #049ddf; font-weight: bold; text-align: center">Brand: <span class="title"><?php echo htmlspecialchars($brandName); ?></span></p> -->
                                </div>
                                <!-- Button style -->
                                <style>
                                    .stylish-linkaa {
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
                                        text-transform: uppercase; /* Uppercase text */
                                        letter-spacing: 1px; /* Slightly spaced letters */
                                        border: 2px solid transparent; /* Add a border for hover effect */
                                        cursor: pointer; /* Pointer cursor on hover */
                                        transition: all 0.3s ease; /* Smooth transition for all properties */
                                        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
                                    }

                                    .stylish-linkaa:hover {
                                        /* background-color: #309ec7; */
                                        color: #f0f0f0;
                                        /* border: 2px solid #ffffff; */
                                        /* transform: translateY(-3px); */
                                        /* box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15); */
                                        /* color: #23527c; */
                                        text-decoration: none;
                                    }
                                </style>
                                <div class="btn" style="display: flex; justify-content: center; padding-bottom: 20px;">
                                    <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="stylish-linkaa" style="padding: 8px 15px;">Read More</a>
                                </div>
                            
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
