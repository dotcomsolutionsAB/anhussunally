<?php 
  // Include the configuration file
  include(__DIR__ . '/inc_files/config.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>AN Hussunally & Co
  </title>
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
  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
  <!--HEADER-->
  <?php include("inc_files/header.php"); ?>
  <style>
    /* Full Page Section */
    .flex {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url("images/About_Us.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        height: 100vh; /* Full-screen height */
    }

    .flex::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black overlay */
        z-index: 1; /* Ensure overlay is behind content */
    }

    .flex > * {
        position: relative;
        z-index: 2; /* Bring content above the overlay */
    }

    /* Grid Layout */
    .brand-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Responsive grid */
        gap: 20px; /* Space between cards */
        max-width: 1200px;
        padding: 40px;
        width: 100%;
    }

    /* Brand Card */
    .brand-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 140px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Brand Logo */
    .brand-logo {
        max-width: 80%;
        max-height: 70%;
        transition: transform 0.3s ease;
    }

    .brand-card:hover .brand-logo {
        transform: scale(1.1);
    }

    /* Responsive Text */
    .flex h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .flex h1 {
        font-size: 28px;
        }

        .brand-card {
        height: 120px;
        }
    }
    @media (max-width: 480px) {
      .brand-card {
          height: 70px;
          width: 100px;
      }

      .brand-logo {
          max-width: 100%;
      }
      .brand-grid {
          grid-template-columns: 1fr 1fr 1fr;
          gap: 10px;
          padding: 10px;
      }
    }
  </style>

<div class="flex">
    <div class="brand-grid">
      <div class="brand-card"><img src="images/ALFOMEGA.png" alt="Brand 1" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Atos.png" alt="Brand 2" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Bearing-Pullers.png" alt="Brand 3" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HYDROLINE.png" alt="Brand 4" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 5" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DEMCON.png" alt="Brand 6" class="brand-logo"></div>
      <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 7" class="brand-logo"></div>
      <div class="brand-card"><img src="images/EPE.jpg" alt="Brand 8" class="brand-logo"></div>
      <div class="brand-card"><img src="images/GEMELS1.png" alt="Brand 9" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HAWE.png" alt="Brand 10" class="brand-logo"></div>
      <div class="brand-card"><img src="images/HYLOC.png" alt="Brand 11" class="brand-logo"></div>
      <div class="brand-card"><img src="images/POLYHYDR0N.png" alt="Brand 12" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Positron-1.png" alt="Brand 13" class="brand-logo"></div>
      <div class="brand-card"><img src="images/REXROTH.png" alt="Brand 14" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Spica.jpg" alt="Brand 15" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Minitest.png" alt="Brand 16" class="brand-logo"></div>
      <div class="brand-card"><img src="images/VELJAN.png" alt="Brand 17" class="brand-logo"></div>
      <div class="brand-card"><img src="images/WIKAI.png" alt="Brand 18" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Water-Test-Pump.png" alt="Brand 19" class="brand-logo"></div>
      <div class="brand-card"><img src="images/YUKEN.png" alt="Brand 20" class="brand-logo"></div>
      <div class="brand-card"><img src="images/VIP.png" alt="Brand 21" class="brand-logo"></div>
      <div class="brand-card"><img src="images/Hose-Crimping-Machine.png" alt="Brand 22" class="brand-logo"></div>
      <div class="brand-card"><img src="images/STAUFF.png" alt="Brand 23" class="brand-logo"></div>
      <div class="brand-card"><img src="images/WALVOIL.png" alt="Brand 24" class="brand-logo"></div>
    </div>
</div>

  <?php include("inc_files/home_about.php"); ?>
  <?php include("inc_files/counts.php"); ?>
  <?php include("inc_files/new_arrival.php"); ?>
    <!--About-->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .body5 {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container5 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section5 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .section:hover {
            transform: translateY(-5px);
        }

        .text5 {
            flex: 1;
        }

        .text h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .text p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .image5 {
            flex: 1;
            text-align: center;
        }

        .image img {
            max-width: 100%;
            border-radius: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .text h2 {
                font-size: 1.5rem;
            }

            .text p {
                font-size: 0.9rem;
            }

            .image {
                margin-top: 20px;
            }
        }
    </style>
    </section>

  <!--Footer-->

  <?php include("inc_files/footer.php"); ?>
  <script src="js/jquery-2.2.3.js">
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOBKD6V47-g_3opmidcmFapb3kSNAR70U">
  </script>
  <script src="js/gmap3.min.js">
  </script>
  <script src="js/bootstrap.min.js">
  </script>
  <script src="js/bootsnav.js">
  </script>
  <script src="js/jquery.parallax-1.1.3.js">
  </script>
  <script src="js/jquery.appear.js">
  </script>
  <script src="js/owl.carousel.min.js">
  </script>
  <script src="js/jquery.cubeportfolio.min.js">
  </script>
  <script src="js/jquery.fancybox.js">
  </script>
  <script src="js/jquery.themepunch.tools.min.js">
  </script>
  <script src="js/jquery.themepunch.revolution.min.js">
  </script>
  <script src="js/revolution.extension.layeranimation.min.js">
  </script>
  <script src="js/revolution.extension.navigation.min.js">
  </script>
  <script src="js/revolution.extension.parallax.min.js">
  </script>
  <script src="js/revolution.extension.slideanims.min.js">
  </script>
  <script src="js/revolution.extension.video.min.js">
  </script>
  <script src="js/kinetic.js">
  </script>
  <script src="js/jquery.final-countdown.js">
  </script>
  <script src="js/functions.js">
  </script>
</body>

</html>