
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

    // Fetch all products from the products table
    $productQuery = "SELECT *, TIMESTAMPDIFF(HOUR, created_at, NOW()) AS hours_since_creation FROM products";
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

  <!--Loader-->
  <?php include("inc_files/loader.php"); ?>
  <!--HEADER-->
  <?php include("inc_files/header.php");?>
  <!-- Breadcumb -->
  <?php include("inc_files/breadcumb.php"); ?>


  <section id="feature_product" class="bottom_half">
    <div class="container">
      <div class="row">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6">
                <div class="product_wrap bottom_half" style="padding-bottom: 0px; padding: 5px; border: 4px solid grey; margin-bottom: 5px;">
                    <?php if ($product['hours_since_creation'] <= 24): ?>
                        <div class="tag-btn"><span class="uppercase text-center" style="color:red;">New</span></div>
                    <?php endif; ?>
                    <div class="image">
                        <?php
                        // Get the first image from the images column
                        $imageIds = explode(',', $product['images']);
                        $firstImageId = $imageIds[0];
                        $imageQuery = "SELECT file_original_name FROM upload WHERE id = $firstImageId";
                        $imageResult = $conn->query($imageQuery);
                        $image = $imageResult->fetch_assoc();
                        $imageLink = $image ? "api/uploads/assets/" . $image['file_original_name'] : "path/to/default-image.jpg";
                        ?>
                        <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>">
                            <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-responsive">
                        </a>
                    </div>
                    <a href="product_detail.php?sku=<?php echo htmlspecialchars($product['sku']); ?>" class="fancybox">
                        <div class="product_desc" style="padding: 2px; margin: 4px; height: 15vh; display: flex; flex-direction: column; justify-content:space-evenly;">
                            <p ><span class="title"><?php echo htmlspecialchars($product['name']); ?></span></p>
                            <p style="color: orangered; font-weight: bold;">Brand :<span class="title"> <?php echo htmlspecialchars($product['brand']); ?></span></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
        <!-- <div class="col-md-3 col-sm-6">
          <div class="product_wrap bottom_half">
            <div class="image">
              <a class="fancybox" href="images/product4.jpg"><img src="images/product4.jpg" alt="Product" class="img-responsive">
              </a>
            </div>
            <div class="product_desc">
              <p class="title">Sacrificial Chair Design </p>
              <span class="price"><i class="fa fa-gbp"></i>170.00</span>
              <a class="fancybox" href="images/product4.jpg" data-fancybox-group="gallery"><i class="fa fa-shopping-bag open"></i></a>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </section>


  <!--Footer-->
  <?php include("inc_files/footer.php");?>

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

<?php  $conn->close();  ?>