<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// db_connection.php - include your DB connection here
include("api/db_connection.php");

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch all brands and their details
$query = "SELECT * FROM brand ORDER BY name";
$result = $conn->query($query);

// Check if there are any brands in the database
if ($result->num_rows > 0):
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
    <style>
        .brand-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 brands per row on large screens */
            gap: 20px;
            padding: 20px;
        }

        .brand-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .brand-card:hover {
            transform: scale(1.05);
        }

        .brand-card img {
            max-width: 100%;
            height: 5em;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .brand-card h3 {
            font-size: 1.2rem;
            color: #333;
            margin: 10px 0;
        }

        .brand-card p {
            font-size: 0.9rem;
            color: #555;
        }

        /* Responsive styles */
        @media (max-width: 1200px) {
            .brand-grid {
                grid-template-columns: repeat(4, 1fr); /* 4 brands per row for tablets */
            }
        }

        @media (max-width: 768px) {
            .brand-grid {
                grid-template-columns: repeat(3, 1fr); /* 3 brands per row for smaller tablets */
            }
        }

        @media (max-width: 576px) {
            .brand-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 brands per row for mobile devices */
            }
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <!-- <?php include("inc_files/loader.php"); ?> -->
    <!-- HEADER -->
    <?php include("inc_files/header.php"); ?>
    <!-- Breadcrumb -->
    <?php include("inc_files/breadcumb.php"); ?>

    <section id="feature_product" class="bottom_half">
        <div class="container">
            <h1>All Brands</h1>
            <div class="brand-grid">
                <?php while ($brand = $result->fetch_assoc()): ?>
                <div class="brand-card">
                    <?php if (!empty($brand['logo'])): ?>
                        <img src="uploads/assets/logos/<?= htmlspecialchars($brand['logo'].".".$brand['extension']); ?>" alt="<?= htmlspecialchars($brand['name']); ?>" />
                        <?php else: ?>
                        <img src="images/default.png" alt="<?= htmlspecialchars($brand['name']); ?>" />
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($brand['name']); ?></h3>
                    <p><strong>Specifications:</strong> <?= !empty($brand['specifications']) ? htmlspecialchars($brand['specifications']) : 'N/A'; ?></p>
                    <p><strong>Extension:</strong> <?= !empty($brand['extension']) ? htmlspecialchars($brand['extension']) : 'N/A'; ?></p>
                    <p><strong>Created At:</strong> <?= date('Y-m-d', strtotime($brand['created_at'])); ?></p>
                    <p><strong>Updated At:</strong> <?= date('Y-m-d', strtotime($brand['updated_at'])); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php
    else:
         echo "<p>No brands found in the database.</p>";
    endif;
?>
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
    // Close the database connection
    $conn->close();
?>
