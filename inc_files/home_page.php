    

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
  <style>
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
    .navbar-default.scrolled ul .dropdown-menu{
      background:#000;
    }
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


  </style>
    <header>
      <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container">
          <!-- Start Header Navigation -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
              <i class="fa fa-bars">
              </i>
            </button>
            <a class="navbar-brand" href="index.php">
              <img src="images/logo.png" class="logo" alt="" id="navbar-logo">
            </a>
          </div>
          <!-- End Header Navigation -->
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
              <li class="dropdown active">
                <a href="https://anh.ongoingwp.xyz/index.php" class="index.php" data-toggle="#home" style="font-weight: bolder;">Home
                </a>
              </li>
              </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-weight: bolder;">Brands</a>
                    <ul class="dropdown-menu" style="margin-top: 2vh; ">
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
              <li class="dropdown" >
                <a href="about_us.php" style="font-weight: bolder;">About Us
                </a>
              </li>
              <li class="dropdown">
                <a href="contact_us.php" style="font-weight: bolder;">Contact us
                </a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <div class=" search-toggle">
            <div class="top-search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon">
                  <i class="fa fa-search">
                  </i>
                </span>
              </div>
            </div>
          </div>
        </div>   
      </nav>
    </header>

   
    <style>
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
          <div class="brand-card"><img src="images/VIP.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/Hose-Crimping-Machine.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/STAUFF.png" alt="Brand 20" class="brand-logo"></div>
          <div class="brand-card"><img src="images/WALVOIL.png" alt="Brand 20" class="brand-logo"></div>
      </div>
    </div>
    <script>
      document.addEventListener('scroll', function() {
          //console.log('Scroll position:', window.scrollY);
          const navbar = document.querySelector('.navbar-default');
          const logo = document.querySelector('#navbar-logo');
          if (window.scrollY > 50) {
              //console.log('Scrolled: Changing to logo22.png');
              navbar.classList.add('scrolled');
              logo.src = 'images/logo22.png';
          } else {
            // console.log('Not Scrolled: Reverting to logo.png');
              navbar.classList.remove('scrolled');
              logo.src = 'images/logo.png';
          }
      });
    </script>