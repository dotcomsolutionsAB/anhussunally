<?php include("api/db_connection.php"); ?>

<?php
// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all brands from the brand table
$brandQuery = "SELECT id, name FROM brand";
$brandResult = $conn->query($brandQuery);
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Wrapper for shared background */
        .shared-background {
            position: relative;
            background-image: url("images/About_Us.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
        }

        /* Overlay */
        .shared-background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
            z-index: 1; /* Ensure overlay appears below content */
            pointer-events: none; /* Allow interactions with content */
        }

        /* Ensure content is above the overlay */
        .shared-background > * {
            position: relative;
            z-index: 2;
        }


        /* Navbar styles */
        .navbar-styled {
            background: none; /* Transparent to show the shared background */
            border: none;
            position: relative;
            z-index: 10; /* Ensure it’s above the background */
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        header .wrap-sticky nav.navbar.bootsnav {
            background: #ffffff00;
        }
        header nav.navbar.bootsnav ul.nav > li > a {
            color: #fff;
            padding-bottom: 2px;
            padding-left: 0px;
            font-weight: 600;
            font-size: 14px;
            padding-right: 0px
        }
        header nav.navbar.bootsnav ul.nav > li > a:hover {
            color:#fff;
        }
        header .wrap-sticky nav.navbar.scrolled {
            background: #fff;
        }
        .navbar-styled.scrolled {
            background-color: rgba(255, 255, 255, 0.9); /* Solid color when scrolled */
            color: #000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-nav > li > a {
            position: relative;
            display: inline-block;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
        header nav.navbar.bootsnav ul.nav > li {
            margin: 0px 10px;
        }
        .navbar-nav > li > a::after {
            content: "";
            position: absolute;
            bottom: -5px; /* Adjust distance from the text */
            left: 0;
            width: 0;
            height: 2px; /* Thickness of the underline */
            background-color: #fff; /* Default underline color */
            transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out; /* Transition for width and color */
        }

        .navbar-nav > li > a:hover::after {
            width: 100%; /* Full underline on hover */
        }

        /* When navbar is scrolled */
        .navbar-styled.scrolled .navbar-nav > li > a::after {
            background-color: #000; /* Black underline when scrolled */
        }
        .navbar-styled.scrolled .navbar-nav > li > a {
            color: #000 !important;
            font-weight: bold;
        }

        .navbar-styled.scrolled .navbar-brand {
            color: #fff !important;
        }

        /* Flex Section */
        .top-section {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
            z-index: 1;
        }

        /* Brand Grid Styles */
        .brand-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Ensure 5 items per row */
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .brand-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 140px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-card img {
            max-width: 80%;
            max-height: 70%;
        }


        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        header .navbar-brand{
            padding-top:15px;
            padding-bottom:15px;
        }



        /* Dropdown menu styles */
        .navbar-nav .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.8); /* Dark transparent background */
            border: none;
            margin-top: 1rem; /* Space below the navbar */
        }

        .navbar-nav .dropdown-menu li a {
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .dropdown-menu li a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Lighter hover effect */
        }
        
    </style>


<!-- Wrapper for shared background -->
<div class="shared-background">
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-styled navbar-sticky bootsnav">
            <div class="container">
                <!-- Navbar Header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo22.png" class="logo" alt="Logo" id="navbar-logo">
                    </a>
                </div>
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class=""><a href="index.php">Home</a></li>
                        <!-- <li class=""><a href="brands.php">Brand</a></li> -->
                        <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Brands</a>
                            <ul class="dropdown-menu">
                                <?php if ($brandResult && $brandResult->num_rows > 0): ?>
                                    <?php while ($brand = $brandResult->fetch_assoc()): ?>
                                        <li>
                                            <a href="brand_details.php?id=<?php echo htmlspecialchars($brand['id']); ?>">
                                                <?php echo htmlspecialchars($brand['name']); ?>
                                            </a>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <li><a href="#">No Brands Available</a></li>
                                <?php endif; ?>
                            </ul>
                        </li> -->

                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="certificates.php">Certificates</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                    </ul>
                </div>

            </div>
        </nav>
    </header>

    <!-- Top Section -->
    <div class="top-section">
        
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
          <div class="brand-card"><img src="images/VIP.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/Hose-Crimping-Machine.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/STAUFF.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/WALVOIL.png" alt="Brand 20" class="brand-logo"></div>
    </div>
</div>

<!-- Script to handle navbar scroll -->
<script>
    document.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar-styled');
        const logo = document.querySelector('#navbar-logo');
          if (window.scrollY > 50) {
              //console.log('Scrolled: Changing to logo22.png');
              navbar.classList.add('scrolled');
              logo.src = 'images/logo.png';
          } else {
            // console.log('Not Scrolled: Reverting to logo.png');
              navbar.classList.remove('scrolled');
              logo.src = 'images/logo22.png';
          }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>