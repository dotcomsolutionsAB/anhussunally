<?php 
  // Include the configuration file
  include(__DIR__ . '/inc_files/config.php');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>About Us</title>
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

    <!--HEADER-->
    <?php include("inc_files/header.php");?>
    <!-- Breadcumb -->
    <?php include("inc_files/breadcumb.php"); ?>
    
    <style>
    /* Testimonial Section */
    .testimonial-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #111;
        height: 100%;
        flex-wrap: wrap; /* Allow the content to wrap on small screens */
    }

    .testimonial-text {
        flex: 1;
        margin: 20px 70px;
        width: 50vw;
        height: 95vh;
        justify-content: center;
        display: flex;
        flex-direction: column;
    }

    .testimonial-text h2 {
        font-size: 4.5em;
        margin-bottom: 20px;
        font-weight: bold;
        text-transform: uppercase;
        color: #fff;
        font-family:'Oswald';
    }

    .testimonial-text h4 {
        font-family:'Oswald';
        font-weight: regular;
        color: #fff;
        text-transform: uppercase;
        font-size: 1.7em;
        margin-bottom: 5px;
    }

    .testimonial-text p {
        font-size: 1.3em;
        line-height: 1.8;
        margin-bottom: 30px;
        color: #ccc;
    }

    .client-info {
        text-align: center;
    }

    .client-info img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .client-info h4 {
        margin: 0;
        font-size: 1em;
        text-transform: uppercase;
        color: #fff;
    }

    .client-info span {
        font-size: 0.9em;
        color: #888;
    }

    .testimonial-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .testimonial-image img {
        width: 100%;
        height: 100%;
    }

    /* Stylish Link */
    .stylish-link {
        display: inline-block;
        width: 150px;
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

    .stylish-link:hover {
        color: #f0f0f0;
        text-decoration: none;
    }

    /* Media Queries for Mobile Devices */

    /* Tablet Devices (up to 1024px) */
    @media (max-width: 1024px) {
        .testimonial-section {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: auto;
            text-align: justify;
        }

        .testimonial-text {
            width: 80vw;
            margin: 20px 0;
            height: auto; /* Remove fixed height */
        }

        .testimonial-image img {
            max-width: 90%; /* Resize image for tablets */
            height: auto; /* Maintain aspect ratio */
        }

        .testimonial-text h2 {
            font-size: 3.5em; /* Adjust text size for tablet */
        }

        .testimonial-text h4 {
            font-size: 1.5em; /* Adjust text size for tablet */
        }

        .testimonial-text p {
            font-size: 1.2em; /* Adjust paragraph font size */
        }

        .stylish-link {
            width: 140px;
            font-size: 12px; /* Adjust button size for smaller screens */
        }
    }

    /* Mobile Devices (up to 768px) */
    @media (max-width: 768px) {
        .testimonial-section {
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .testimonial-text {
            width: 90vw;
            margin: 10px 0;
        }

        .testimonial-text h2 {
            font-size: 2.8em; /* Adjust text size for mobile */
        }

        .testimonial-text h4 {
            font-size: 1.3em; /* Adjust text size for mobile */
        }

        .testimonial-text p {
            font-size: 1.1em; /* Adjust paragraph font size for mobile */
            line-height: 1.6;
        }

        .testimonial-image img {
            width: 100%;
            height: auto; /* Resize image for mobile */
        }

        .stylish-link {
            width: 130px;
            font-size: 11px; /* Adjust button size for mobile */
        }
    }

    /* Small Mobile Devices (up to 480px) */
    @media (max-width: 480px) {
        .testimonial-text {
            padding: 10px;
            text-align: justify;
            margin-bottom: 25px;
        }

        .testimonial-text h2 {
            font-size: 2.5em;
        }

        .testimonial-text h4 {
            font-size: 1.2em;
        }

        .testimonial-text p {
            font-size: 1em;
            line-height: 1.5;
        }

        .testimonial-image {
            width: 100vw; /* Full width */
            height: 65vh; /* 50% of viewport height */
        }

        .testimonial-image img {
            width: 100%;
            height: 45vh;
            object-fit: cover;
            transform: scale(1.1); /* Zoom effect */
        }

        .stylish-link {
            width: 120px;
            font-size: 10px;
        }
    }

</style>
<section class="testimonial-section">
    <div class="testimonial-text">
        <h4>A.N. Hussunally & Co</h4>
        <h2>About Us</h2>
        <p>
            Pioneering the hydraulics market in Eastern India, the 100-year old A.N. Hussunally & Co. has today emerged as among the    market leaders in providing customers with holistic hydraulic solutions.<br><br>

            Established in 1917, the Company’s principal business philosophy is anchored on providing customers with world-clasproducts and solutions at cost-effective propositions. Today, the Company comprehensively caters to the needs of a vasspectrum of industries in the pneumatics, oil and gas, power, steel, cement, manufacturing and chemicals industries<br><br>

            With strong resident knowledge and knowhow of the dynamic hydraulics industry coupled with state-of-the-arinfrastructure and resource base, A.N. Hussunally & Co. has actively engaged in nation-building by participating isuch landmark Indian projects as the Tata Steel complex in Jamshedpur, Bhusan Power & Steel, Jindal Steel, ISSCO SteePlant etc.
        </p>
        <style>
            .stylish-link {
                display: inline-block;
                width: 150px;
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

            .stylish-link:hover {
                /* background-color: #309ec7; */
                color: #f0f0f0;
                /* border: 2px solid #ffffff; */
                /* transform: translateY(-3px); */
                /* box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15); */
                /* color: #23527c; */
                text-decoration: none;
            }
        </style>
        <a href="../about-us.php" class="stylish-link">Read More</a>

    </div>
    <div class="testimonial-image">
        <img src="images/about-1.jpg" alt="Feedback">
    </div>
</section>

    <br><br>
    <!-- Imggg -->
    <?php include("inc_files/imggg.php"); ?>
    <!-- Breadcumb -->
    <?php include("inc_files/counts.php"); ?>
    <br><br>
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