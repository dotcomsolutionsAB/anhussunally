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
    padding-bottom: 40px;
}

.shared-background::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
    z-index: 1;
}

.shared-background > * {
    position: relative;
    z-index: 2;
}

/* Navbar styles */
.navbar-styled {
    background: none;
    border: none;
    position: relative;
    z-index: 10;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-styled.scrolled {
    background-color: rgba(255, 255, 255, 0.9);
    color: #000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.navbar-nav > li > a {
    color: white;
    font-weight: bold;
    text-decoration: none;
    padding: 10px 15px;
}

.navbar-nav > li > a:hover {
    color: #f8f9fa;
}

.navbar-styled.scrolled .navbar-nav > li > a {
    color: #000 !important;
}

.navbar-toggle {
    border: none;
}

.navbar-toggle .icon-bar {
    background-color: white;
}

/* Brand grid styles */
.top-section {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Default for desktop */
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px;
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

/* Responsive Styles */

/* Tablet view (768px and below) */
@media (max-width: 768px) {
    .top-section {
        grid-template-columns: repeat(3, 1fr); /* 3 items per row */
        gap: 15px;
        padding: 20px;
    }

    .brand-card {
        height: 120px;
    }

    .brand-card img {
        max-width: 70%;
    }

    .navbar-nav > li > a {
        font-size: 14px;
    }
}

/* Mobile view (480px and below) */
@media (max-width: 480px) {
    .top-section {
        grid-template-columns: repeat(2, 1fr); /* 2 items per row */
        gap: 10px;
        padding: 15px;
    }

    .brand-card {
        height: 100px;
    }

    .brand-card img {
        max-width: 60%;
    }

    .navbar-styled {
        padding: 10px;
    }

    .navbar-nav {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar-nav > li {
        width: 100%;
    }

    .navbar-nav > li > a {
        padding: 10px;
        font-size: 12px;
    }

    .navbar-header .navbar-brand img {
        max-width: 80%;
    }
}
    </style>


<!-- Shared Background Wrapper -->
<div class="shared-background">
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-styled navbar-sticky bootsnav">
            <div class="container-fluid">
                <!-- Navbar Header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo22.png" class="logo" alt="Logo" id="navbar-logo">
                    </a>
                </div>
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="certificates.php">Certificates</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Top Section -->
    <?php
    // Show the section only if the current page is "index"
    if ($current_page === 'index'): ?>
        <div class="top-section">
            <div class="brand-card"><img src="images/ALFOMEGA.png" alt="Brand 1"></div>
            <div class="brand-card"><img src="images/Atos.png" alt="Brand 2"></div>
            <div class="brand-card"><img src="images/Bearing-Pullers.png" alt="Brand 3"></div>
            <div class="brand-card"><img src="images/HYDROLINE.png" alt="Brand 4"></div>
            <div class="brand-card"><img src="images/DOWTY.png" alt="Brand 5"></div>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar-styled');
        const logo = document.querySelector('#navbar-logo');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            logo.src = 'images/logo.png';
        } else {
            navbar.classList.remove('scrolled');
            logo.src = 'images/logo22.png';
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>