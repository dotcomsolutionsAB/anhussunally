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
        .navbar-default {
            background-color: transparent; /* Initial transparent background */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-default.scrolled {
            background-color: black !important; /* Background after scrolling */
            color: white; /* Font color after scrolling */
        }

        .navbar-default.scrolled .navbar-nav > li > a {
            color: white !important; /* Change nav link colors */
            font-weight: bold;
        }

        .navbar-default.scrolled .navbar-brand {
            color: white !important; /* Change brand color */
        }

        li.dropdown a {
            position: relative;
            display: inline-block;
            color: #000; /* Adjust color as needed */
            text-decoration: none;
            font-weight: bold;
        }

        li.dropdown a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px; /* Adjust thickness of underline */
            background-color: #000; /* Adjust underline color */
            transition: width 0.3s ease-in-out;
        }

        li.dropdown a:hover::after {
            width: 100%; /* Expands the underline to full width on hover */
        }

        /* Underline effect when navbar is scrolled */
        .navbar-default.scrolled li.dropdown a::after {
            background-color: #fff; /* Change underline to white when scrolled */
        }

        .navbar-default.scrolled ul .dropdown-menu {
            background: #000;
        }

        .brand-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 30px;
            max-width: 1200px;
            justify-content: center;
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .brand-card {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            height: 120px;
        }

        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .brand-logo {
            max-width: 100%;
            max-height: 60px;
            object-fit: contain;
        }

        .flex {
            position: relative; /* Needed to position the overlay correctly */
            display: flex;
            justify-content: center;
            background-image: url("images/About_Us.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #f9f9f9;
            background-attachment: scroll;
            height: 100vh; /* Adjust height as needed */
            color: white; /* Text color to stand out against the dark overlay */
        }

        .flex::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
            pointer-events: none; /* Ensure the overlay doesn’t interfere with interactions */
            z-index: 1; /* Make sure the overlay is behind the content */
        }

        .flex > * {
            position: relative;
            z-index: 2; /* Bring the content above the overlay */
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container">
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo.png" class="logo" alt="" id="navbar-logo">
                </a>
            </div>
            <!-- End Header Navigation -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
                    <li class="dropdown active">
                        <a href="index.php" style="font-weight: bolder;">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-weight: bolder;">Brands</a>
                        <ul class="dropdown-menu" style="margin-top: 2vh;">
                            <?php if ($brandResult && $brandResult->num_rows > 0): ?>
                                <?php while ($brand = $brandResult->fetch_assoc()): ?>
                                    <li>
                                        <a href="brands.php?id=<?php echo htmlspecialchars($brand['id']); ?>" style="padding: 0px 10px; font-size: 15px;">
                                            <?php echo htmlspecialchars($brand['name']); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li><a href="#">No Brands Available</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="about_us.php" style="font-weight: bolder;">About Us</a>
                    </li>
                    <li class="dropdown">
                        <a href="contact_us.php" style="font-weight: bolder;">Contact us</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            <div class="search-toggle">
                <div class="top-search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="flex">
    <div class="brand-grid">
        <!-- Add your brand logos dynamically or as needed -->
        <div class="brand-card"><img src="images/ALFOMEGA.png" alt="Brand 1" class="brand-logo"></div>
        <!-- Repeat for other brands -->
    </div>
</div>

<script>
    document.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar-default');
        const logo = document.querySelector('#navbar-logo');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            logo.src = 'images/logo22.png'; // Update to a different logo after scrolling
        } else {
            navbar.classList.remove('scrolled');
            logo.src = 'images/logo.png'; // Original logo before scrolling
        }
    });
</script>
</body>
</html>
