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