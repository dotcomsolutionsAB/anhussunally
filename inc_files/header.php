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
      background:#fff;
    }
    .navbar-default {
          background-color: transparent; /* Initial transparent background */
          transition: background-color 0.3s ease, color 0.3s ease;
      }

      .navbar-default.scrolled {
          background-color: #fff !important; /* Background after scrolling */
          color: white; /* Font color after scrolling */
          box-shadow: 0px 0px 60px 0px rgba(0, 0, 0, 0.1);
          
      }

      .navbar-default.scrolled .navbar-nav > li > a {
          color: #000 !important; /* Change nav link colors */
          font-weight: bold;
      }

      .navbar-default.scrolled .navbar-brand {
          color: white !important; /* Change brand color */
      }
      li.dropdown a::after {
        bottom: 20px !important;
      }
      .wrap-sticky{
        height: 76px;
      }
      

  </style>

<style>
        /* styles.css */

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 10vw;
            height: 10vh;
            background: aqua;
            transition: all 0.5s ease-in-out;
            position: relative;
        }

        /* Search icon button (🔍 emoji) */
        #search-icon {
            font-size: 30px; /* Adjust size for visibility */
            cursor: pointer;
            transition: 0.3s;
        }

        /* The sliding search bar (initially hidden) */
        #search-bar {
            position: absolute;
            top: 0;
            right: -300px;
            width: 100%;
            max-width: 300px;
            padding: 15px;
            background-color: yellow;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.5s;
            display: none; /* Hide the search bar initially */
        }

        #search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #clear-icon {
            cursor: pointer;
            font-size: 18px;
            display: none;
            position: absolute;
            right: 40px;
            top: 15px;
        }

        /* Results container */
        #search-results {
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
        }

        .result-item {
            padding: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-item img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        /* Media query for responsiveness */
        @media (max-width: 600px) {
            #search-bar {
                max-width: 100%;
            }
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
          <!-- Search bar -->
          <div class="navbar-header">
            <div class="search-container">
              <!-- Search icon (🔍 emoji) -->
              <span id="search-icon" onclick="openSearchBar()">🔍</span>
              
              <!-- The search bar -->
              <div id="search-bar">
                  <input type="text" id="search" placeholder="Search by SKU or Name..." onkeyup="searchProducts()">
                  <span id="clear-icon" onclick="clearSearch()">&#10005;</span>
                  <div id="search-results"></div> <!-- Where the search results will be displayed -->
              </div>
            </div>
          </div>
          <!-- End Header Navigation -->
          <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
              <li class="dropdown active">
                <a href="index.php" class="index.php" data-toggle="#home" style="font-weight: bolder;">Home
                </a>
              </li>
              </li>
                <!-- <li class="dropdown">
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
                </li> -->

              
              <li class="dropdown" >
                <a href="about_us.php" style="font-weight: bolder;">About Us
                </a>
              </li>
              <li class="dropdown" >
                <a href="#" style="font-weight: bolder;">Certificates
                </a>
              </li>
              <li class="dropdown">
                <a href="contact_us.php" style="font-weight: bolder;">Contact us
                </a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <div class="search-toggle">
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

    <script>
      document.addEventListener('scroll', function() {
          //console.log('Scroll position:', window.scrollY);
          const navbar = document.querySelector('.navbar-default');
          const logo = document.querySelector('#navbar-logo');
          if (window.scrollY > 50) {
              //console.log('Scrolled: Changing to logo22.png');
              navbar.classList.add('scrolled');
              logo.src = 'images/logo.png';
          } else {
            // console.log('Not Scrolled: Reverting to logo.png');
              navbar.classList.remove('scrolled');
              logo.src = 'images/logo.png';
          }
      });
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script> <!-- Link to external JS file -->
    <script>
        // Open the search bar and hide the search icon
        function openSearchBar() {
            document.getElementById('search-bar').style.right = '0'; // Slide the bar in from the right
            document.getElementById('search-bar').style.display = 'block'; // Show the search bar
            document.getElementById('search-icon').style.display = 'none'; // Hide the search icon
            document.querySelector('.search-container').style.width = '35vw'; // Expand container width
            document.querySelector('.search-container').style.height = '10vh'; // Keep container height
        }

        // Clear the search input
        function clearSearch() {
            document.getElementById('search').value = ''; // Clear the search input
            document.getElementById('clear-icon').style.display = 'none'; // Hide the clear icon
            document.getElementById('search-results').innerHTML = ''; // Clear search results
        }

        // Show or hide the clear icon based on input length
        function searchProducts() {
            let query = document.getElementById('search').value;

            if (query.length >= 2) { // Show the clear icon after typing 2 characters
                document.getElementById('clear-icon').style.display = 'block';
            } else {
                document.getElementById('clear-icon').style.display = 'none';
            }

            if (query.length >= 3) { // Start searching after 3 characters
                $.ajax({
                    url: '../search_api.php',
                    type: 'GET',
                    data: {
                        search_query: query
                    },
                    success: function(response) {
                        document.getElementById('search-results').innerHTML = response;
                    }
                });
            } else {
                document.getElementById('search-results').innerHTML = ''; // Clear results if search is too short
            }
        }
    </script>