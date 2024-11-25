<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Navbar Styling */
        .navbar-default {
            background: none;
            border: none;
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease, padding 0.3s ease;
        }

        .navbar-default.scrolled {
            background-color: rgba(0, 0, 0, 0.9); /* Black background on scroll */
        }

        .navbar-default .navbar-nav {
            display: flex;
            justify-content: center; /* Align nav links horizontally */
            align-items: center; /* Align nav links vertically */
            margin: 0 auto;
        }

        .navbar-default .navbar-nav > li > a {
            color: white;
            font-weight: normal;
            text-decoration: none;
            position: relative;
            transition: color 0.3s ease, font-weight 0.3s ease;
        }

        /* Underline Animation */
        .navbar-default .navbar-nav > li > a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: white;
            transition: width 0.3s ease;
        }

        .navbar-default .navbar-nav > li > a:hover::after {
            width: 100%;
        }

        .navbar-default .navbar-nav > li > a:hover {
            font-weight: bold;
        }

        .navbar-default .navbar-brand img {
            height: 50px;
            transition: height 0.3s ease;
        }

        .navbar-default.scrolled .navbar-brand img {
            height: 40px;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 100vh;
            background: url('images/About_Us.png') no-repeat center center/cover;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Light black overlay */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            padding-top: 20%;
        }

        /* Brand Grid in Hero Section */
        .hero-brands {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 3;
        }

        .brand-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
        }

        .brand-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
        }

        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .brand-logo {
            max-width: 100%;
            max-height: 60px;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
            }

            .navbar-brand img {
                height: 40px;
            }

            .hero-brands {
                bottom: 10px;
            }
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo22.png" alt="Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about_us.php">About Us</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<section class="hero-section">
    <div class="hero-brands">
        <div class="brand-grid">
            <div class="brand-card"><img src="images/ALFOMEGA.png" alt="Brand 1" class="brand-logo"></div>
            <div class="brand-card"><img src="images/Atos.png" alt="Brand 2" class="brand-logo"></div>
            <div class="brand-card"><img src="images/Bearing-Pullers.png" alt="Brand 3" class="brand-logo"></div>
            <div class="brand-card"><img src="images/HYDROLINE.png" alt="Brand 4" class="brand-logo"></div>
            <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 5" class="brand-logo"></div>
            <div class="brand-card"><img src="images/DEMCON.png" alt="Brand 6" class="brand-logo"></div>
        </div>
    </div>
</section>

<script>
    // Change navbar background on scroll
    document.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar-default');
        const heroSection = document.querySelector('.hero-section');
        const scrollPosition = window.scrollY;
        const heroHeight = heroSection.offsetHeight;

        if (scrollPosition > heroHeight * 0.5) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>
