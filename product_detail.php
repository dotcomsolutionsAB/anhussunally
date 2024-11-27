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
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
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
  <!-- <?php include("inc_files/loader.php"); ?> -->
  <!--HEADER-->
  <?php include("inc_files/header.php"); ?>
  <!-- Breadcumb -->
  <?php include("inc_files/breadcumb.php"); ?>
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
      $images[] = "/api/uploads/assets/" . $image['file_original_name'];
    }
    $stmt->close();
  }
  ?>

  <section id="cart" class="padding_bottom">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">

          <div id="slider_product" class="cbp margintop40">
            <div class="cbp-item">
              <div class="cbp-caption">
                <?php if (!empty($images)): ?>
                  <?php foreach ($images as $index => $imageLink): ?>
                    <div class="cbp-caption-defaultWrap <?php echo $index === 0 ? 'cbp-pagination-active' : ''; ?>">
                      <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="">
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="cbp-caption-defaultWrap">
                      <img src="images/default.png" alt="">
                    </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- <div id="js-pagination-slider">
            <div class="cbp-pagination-item cbp-pagination-active">
              <img src="images/Pipe_Clamps.jpg" alt="">
            </div>
          </div> -->
          <!-- Image Slider Section -->
          <div id="js-pagination-slider">
            <?php if (!empty($images)): ?>
              <?php foreach ($images as $index => $imageLink): ?>
                <div class="cbp-pagination-item <?php echo $index === 0 ? 'cbp-pagination-active' : ''; ?>">
                  <img src="<?php echo htmlspecialchars($imageLink); ?>" alt="Product Image">
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No images available.</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="detail_pro margintop40">
            <h1 class=""><?php echo htmlspecialchars($product['name']); ?></h1>
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
                    <div class="image2">
                        <a href="#">
                            <img src="<?php echo $brandLogo; ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image" style="width:15rem;">
                        </a>
                    </div>
                <?php
                  } else {
                ?>
                <p style="color: #7ab6c8; font-weight: bold;">Brand :
                  <a href="#">
                    <span class="title"><?php echo htmlspecialchars($brand['name']); ?></span>
                  </a>
                </p>
                <?php
                  }
                ?>
            </p>
            <div class="product_meta">
              <span class="sku_wrapper">
                <strong>SKU: </strong>
                <span class="sku"> <?php echo htmlspecialchars($product['sku']); ?></span>
              </span>
              <br>
              <span class="posted_in">
                <strong>Categories: </strong>
                <a href="#" rel="tag"><?php echo htmlspecialchars($product['category']); ?></a>, <a href="#" rel="tag">Child Category</a>
              </span>
            </div>
            <!-- <p class="stock in-stock"><strong>Status: </strong>In stock</p> -->
            <br>
            <p class="bottom30"><?php echo nl2br(htmlspecialchars($product['short_description'])); ?></p>

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
            <!-- <ul class="review_list marginbottom15">
              <li><img src="images/star.png" alt="star">
              </li>
              <li><a href="#.">10 review(s) </a>
              </li>
              <li><a href="#.">Add your review</a>
              </li>
            </ul>
            <h2 class="price marginbottom15"><i class="fa fa-gbp"></i>70.00</h2>

            <form class="cart-form">
              <div class="form-group">
                <label for="city">
                  Size *
                </label>
                <label class="select form-control">
                  <select name="country" id="city">
                    <option selected>- Please select -</option>
                    <option>Canada</option>
                    <option>Chilli</option>
                    <option>France</option>
                  </select>
                </label>
              </div>
              <div class="form-group">
                <label for="city">
                  Color *
                </label>
                <label class="select form-control">
                  <select name="country" id="color">
                    <option selected>- Please select -</option>
                    <option>Canada</option>
                    <option>Chilli</option>
                    <option>France</option>
                  </select>
                </label>
              </div>
              <p class="text-danger">Repuired Fiields *</p>
            </form>
            <form class="cart-form">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-3">
                    <label for="quan">
                      Quantity *
                    </label>
                  </div>
                  <div class="col-sm-6">
                    <label class="select form-control">
                      <select name="country" id="selection">
                        <option selected>- 01 -</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                      </select>
                    </label>
                  </div>
                </div>
              </div>
            </form>
            <div class="cart-buttons">
              <a class="uppercase border-radius btn-dark" href="cart.html"><i class="fa fa-shopping-basket"></i> &nbsp; Add to cart</a>
              <a class="icons" href="#.">
                <i class="fa fa-heart-o"></i>
              </a>
              <a class="icons" href="#.">
                <i class="fa fa-exchange"></i>
              </a>
            </div>

            <div class="cart-share margintop30">
              <ul>
                <li><a href="#." class="facebook"><i class="fa fa-facebook-official"></i><span>Like</span></a>
                </li>
                <li><a href="#." class="twitter"><i class="fa fa-twitter"></i><span>Tweet</span></a>
                </li>
                <li><a href="#." class="google"><i class="fa fa-google"></i></a>
                </li>
                <li><a href="#." class="share"><i class="fa fa-plus-square"></i><span>Share</span></a>
                </li>
              </ul>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- <section class="bottom_half container" style="padding-bottom: 0px; background: #fff; padding: 35px 5px; border-radius: 20px;">
    <div class="container">
      <div class="row">
        <div class="clearfix col-md-12">
          <div class="shop_tab">
            <ul class="tabs">
              <li class="active" rel="tab1">
                <h4 class="heading uppercase">Description</h4>
              </li>
              <li rel="tab2">
                <h4 class="heading uppercase">Customer Review</h4>
              </li>
              <li rel="tab3">
                <h4 class="heading uppercase">Product Tags</h4>
              </li>
            </ul>
            <div class="tab_container">
              <div id="tab1" class="tab_content">
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?>
              </div>

              <div id="tab2" class="tab_content">
                <ol class="commentlist">
                  <li>
                    <div class="avator clearfix"><img src="images/testinomial1.png" class="img-responsive border-radius" alt="author">
                    </div>
                    <div class="comment-content"> <span class="stars"><img alt="star rating" src="images/star.png"></span> <strong>Cobus Bester</strong> -
                      <time datetime="2016-04-07T11:58:43+00:00">April 7, 2016</time>
                      <p>This album proves why The Woo are the best band ever. Best music ever!</p>
                    </div>
                  </li>
                  <li>
                    <div class="avator clearfix"><img src="images/testinomial1.png" class="img-responsive border-radius" alt="author">
                    </div>
                    <div class="comment-content"> <span class="stars"><img alt="star rating" src="images/star.png"></span> <strong>Cobus Bester</strong> -
                      <time datetime="2016-04-07T11:58:43+00:00">April 7, 2016</time>
                      <p>This album proves why The Woo are the best band ever. Best music ever!</p>
                    </div>
                  </li>
                </ol>

                <form class="review-form margintop15">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="control-label">Your Review</label>
                      <textarea class="form-control" rows="3" placeholder="Your Review"></textarea>
                    </div>
                    <div class="col-sm-6 form-group">
                      <label for="inputPassword" class="control-label">Name</label>
                      <input type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label for="inputPassword" class="control-label">Password</label>
                      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                    <div class="col-sm-12">
                      <input type="submit" class="btn-light border-radius" value="Submit">
                    </div>
                  </div>
                </form>
              </div>

              <div id="tab3" class="tab_content">
                <div class="row">
                  <div class="col-md-6">
                    <table class="table table-responsive table-striped">
                      <tbody>
                        <tr>
                          <td>Part Number</td>
                          <td>60-MCTE</td>
                        </tr>
                        <tr>
                          <td>Item Weight</td>
                          <td>54 pounds</td>
                        </tr>
                        <tr>
                          <td>Product Dimensions</td>
                          <td>92.8 inches</td>
                        </tr>
                        <tr>
                          <td>Item model number</td>
                          <td>60-MCTE</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table table-responsive table-striped">
                      <tbody>
                        <tr>
                          <td>Item Package Quantity</td>
                          <td>1</td>
                        </tr>
                        <tr>
                          <td>Number of Handles</td>
                          <td>1</td>
                        </tr>
                        <tr>
                          <td>Batteries Required?</td>
                          <td>NO</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->


 <?php  include("inc_files/related_products.php"); ?>


  <!--Footer-->
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